const WebSocket = require('ws');

// Set up a WebSocket server on port 8080
const wss = new WebSocket.Server({ port: 8080 });

wss.on('connection', (ws) => {
    console.log('Client connected');
    
    // When the server receives a message from the client
    ws.on('message', (message) => {
        console.log(`Received: ${message}`);
        ws.send('Hello from WebSocket server!');
    });

    // Handle WebSocket errors
    ws.on('error', (error) => {
        console.error('WebSocket error:', error);
    });

    // When the connection is closed
    ws.on('close', () => {
        console.log('Client disconnected');
    });
});

console.log('WebSocket server running on ws://localhost:8080');
