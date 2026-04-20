/**
 * api.ts  — The single file that talks to the Laravel backend.
 *
 * WHY have this file?
 * Instead of writing fetch() calls in every component, we put all
 * backend communication here. Components just call functions like
 * api.login(...) or api.getInventory() without knowing the URL details.
 *
 * HOW authentication works:
 * 1. User logs in → backend returns a token
 * 2. We save that token to localStorage
 * 3. Every future request automatically includes the token
 * 4. The backend verifies the token and knows who is making the request
 */

// The base URL of your Laravel backend API.
// In development, Laravel runs on port 8000 by default.
// Change this to your production URL when you deploy.
const BASE_URL = import.meta.env.VITE_API_URL ?? 'http://localhost:8000/api';

// ─── Token helpers ────────────────────────────────────────────────────────────

/** Save the auth token after login */
export function saveToken(token: string) {
  localStorage.setItem('poachy-token', token);
}

/** Get the stored token (or null if not logged in) */
export function getToken(): string | null {
  return localStorage.getItem('poachy-token');
}

/** Remove the token on logout */
export function clearToken() {
  localStorage.removeItem('poachy-token');
  localStorage.removeItem('poachytr-authenticated'); // Remove old flag too
}

/** Check if the user has a token stored (i.e., is logged in) */
export function isAuthenticated(): boolean {
  return !!getToken();
}

// ─── Core request function ────────────────────────────────────────────────────

/**
 * Makes an HTTP request to the Laravel API.
 *
 * @param method  - 'GET', 'POST', 'PUT', 'DELETE'
 * @param path    - The route path, e.g. '/login' or '/inventory'
 * @param body    - Data to send (for POST/PUT requests)
 */
async function request<T>(
  method: string,
  path: string,
  body?: Record<string, unknown>
): Promise<T> {
  const token = getToken();

  const headers: Record<string, string> = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  };

  // If we have a token, attach it to every request
  // The backend uses this to identify who is making the request
  if (token) {
    headers['Authorization'] = `Bearer ${token}`;
  }

  const response = await fetch(`${BASE_URL}${path}`, {
    method,
    headers,
    body: body ? JSON.stringify(body) : undefined,
    credentials: 'include',   // required for Sanctum CSRF cookies
  });

  // If the server returns 401 (Unauthorized), the token has expired or is invalid
  // Clear it and reload so the user is sent back to the login page
  if (response.status === 401) {
    clearToken();
    window.location.href = '/login';
    throw new Error('Session expired. Please log in again.');
  }

  const data = await response.json();

  // If the server returned an error status (4xx or 5xx), throw an error
  // with the server's message (e.g. "The provided credentials are incorrect.")
  if (!response.ok) {
    const message = data?.message ?? data?.errors?.email?.[0] ?? 'Something went wrong';
    throw new Error(message);
  }

  return data as T;
}

// ─── Auth API calls ───────────────────────────────────────────────────────────

export const auth = {
  /**
   * Log in with email and password.
   * Returns { user, token } on success.
   */
  login: (email: string, password: string) =>
    request<{ user: User; token: string }>('POST', '/login', { email, password }),

  /**
   * Register a new account.
   */
  register: (name: string, email: string, password: string, password_confirmation: string) =>
    request<{ user: User; token: string }>('POST', '/register', {
      name, email, password, password_confirmation,
    }),

  /** Log out (deletes the server-side token) */
  logout: () => request<{ message: string }>('POST', '/logout'),

  /** Get the currently logged-in user's profile */
  me: () => request<User>('GET', '/me'),
};

// ─── Dashboard API calls ──────────────────────────────────────────────────────

export const dashboard = {
  get: () => request<DashboardData>('GET', '/dashboard'),
};

// ─── Inventory API calls ──────────────────────────────────────────────────────

export const inventory = {
  getAll: () => request<{ data: InventoryItem[]; total: number }>('GET', '/inventory'),
  add: (item: Omit<InventoryItem, 'id' | 'status'>) =>
    request<{ data: InventoryItem; message: string }>('POST', '/inventory', item as Record<string, unknown>),
  update: (id: number, updates: Partial<InventoryItem>) =>
    request<{ message: string }>('PUT', `/inventory/${id}`, updates as Record<string, unknown>),
  delete: (id: number) =>
    request<{ message: string }>('DELETE', `/inventory/${id}`),
};

// ─── POS API calls ────────────────────────────────────────────────────────────

export const pos = {
  getProducts: () => request<{ data: POSProduct[] }>('GET', '/pos/products'),
  recordSale: (saleData: SalePayload) =>
    request<SaleReceipt>('POST', '/pos/sale', saleData as unknown as Record<string, unknown>),
};

// ─── Reports API calls ────────────────────────────────────────────────────────

export const reports = {
  get: () => request<ReportsData>('GET', '/reports'),
};

// ─── TypeScript types (shapes of the data) ───────────────────────────────────

export interface User {
  id: number;
  name: string;
  email: string;
}

export interface InventoryItem {
  id: number;
  name: string;
  sku: string;
  category: string;
  price: number;
  stock: number;
  status: 'In Stock' | 'Low Stock' | 'Out of Stock';
}

export interface POSProduct {
  id: number;
  name: string;
  price: number;
  category: string;
  emoji: string;
  stock: number;
}

export interface SaleItem {
  product_id: number;
  quantity: number;
  unit_price: number;
}

export interface SalePayload {
  items: SaleItem[];
  total: number;
  payment_method: 'cash' | 'mpesa' | 'card';
  customer_name?: string;
}

export interface SaleReceipt {
  message: string;
  receipt_number: string;
  total: number;
  payment_method: string;
}

export interface DashboardData {
  stats: Array<{ label: string; value: string; trend: string; up: boolean }>;
  recent_sales: Array<{ id: string; customer: string; amount: string; status: string; time: string }>;
  low_stock_alerts: Array<{ product: string; stock: number; reorder: number }>;
}

export interface ReportsData {
  weekly_revenue: Array<{ day: string; amount: number }>;
  sales_by_category: Array<{ category: string; percentage: number; amount: string }>;
  summary: { total_revenue: string; total_sales: number; avg_sale_value: string; top_product: string };
}
