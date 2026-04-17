const http = require('http');
const PORT = process.env.PORT || 4500;

const server = http.createServer((req, res) => {
  const { method, url } = req;

  // @endpoint GET /login
  if (method === 'GET' && url === '/login') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ message: 'Login page', app: 'Poachy' }));
    return;
  }

  // @endpoint GET /dashboard
  if (method === 'GET' && url === '/dashboard') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({
      message: 'Dashboard data',
      stats: {
        totalSales: 15000,
        totalCustomers: 120,
        totalProducts: 85,
        totalExpenses: 3200
      }
    }));
    return;
  }

  // @endpoint GET /customers
  if (method === 'GET' && url === '/customers') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({
      message: 'Customer list',
      data: [
        { id: 1, name: 'Ali Hassan', email: 'ali@example.com', phone: '+254700000001' },
        { id: 2, name: 'Fatuma Omar', email: 'fatuma@example.com', phone: '+254700000002' }
      ]
    }));
    return;
  }

  // @endpoint GET /inventory
  if (method === 'GET' && url === '/inventory') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({
      message: 'Inventory list',
      data: [
        { id: 1, name: 'Product A', quantity: 50, price: 200 },
        { id: 2, name: 'Product B', quantity: 30, price: 450 }
      ]
    }));
    return;
  }

  // @endpoint GET /pos
  if (method === 'GET' && url === '/pos') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({
      message: 'Point of Sale interface',
      session: { cashier: 'Mock Cashier', terminal: 'POS-01' }
    }));
    return;
  }

  // @endpoint GET /ecommerce
  if (method === 'GET' && url === '/ecommerce') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({
      message: 'Ecommerce marketplace',
      listings: [
        { id: 1, title: 'Item X', price: 1200, stock: 10 },
        { id: 2, title: 'Item Y', price: 800, stock: 5 }
      ]
    }));
    return;
  }

  // @endpoint GET /expenses
  if (method === 'GET' && url === '/expenses') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({
      message: 'Expense records',
      data: [
        { id: 1, category: 'Rent', amount: 1500, date: '2025-04-01' },
        { id: 2, category: 'Utilities', amount: 300, date: '2025-04-05' }
      ]
    }));
    return;
  }

  // @endpoint GET /reports
  if (method === 'GET' && url === '/reports') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({
      message: 'Business reports',
      summary: { revenue: 15000, expenses: 3200, profit: 11800 }
    }));
    return;
  }

  // @endpoint GET /settings
  if (method === 'GET' && url === '/settings') {
    res.writeHead(200, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({
      message: 'Application settings',
      settings: { currency: 'KES', timezone: 'Africa/Nairobi', language: 'en' }
    }));
    return;
  }

  // Fallback for unmocked routes
  res.writeHead(404, { 'Content-Type': 'application/json' });
  res.end(JSON.stringify({ error: 'Mock route not defined', method, url }));
});

server.listen(PORT, () => console.log('Poachy API Mock running on port ' + PORT));
