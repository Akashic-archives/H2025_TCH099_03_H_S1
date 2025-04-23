const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8080 });
const waitingPlayers = [];
const matches = new Map(); // userID -> opponent's WebSocket

function onMatch(player1, player2, userID1, userID2) {
  console.log(`Matched: ${userID1} vs ${userID2}`);
  matches.set(userID1, player2);
  matches.set(userID2, player1);

  player1.send(JSON.stringify({ type: 'matched', opponent: userID2 }));
  player2.send(JSON.stringify({ type: 'matched', opponent: userID1 }));
}

wss.on('connection', (ws) => {
  let userID = null;

  ws.on('message', (msg) => {
    try {
      const data = JSON.parse(msg);
      if (data.type === 'join' && data.userID) {
        userID = data.userID;
        ws.userID = userID;
        console.log(`${userID} joined`);

        if (waitingPlayers.length > 0) {
          const opponent = waitingPlayers.shift();
          const opponentID = opponent.userID;
          onMatch(ws, opponent, userID, opponentID);
        } else {
          waitingPlayers.push(ws);
        }
      }

      if (data.type === 'ping' && data.userID) {
        const opponentSocket = matches.get(data.userID);
        if (opponentSocket && opponentSocket.readyState === WebSocket.OPEN) {
          opponentSocket.send(JSON.stringify({ type: 'ping', from: data.userID }));
        }
      }
    } catch (e) {
      console.error('Invalid message:', msg);
    }
  });

  ws.on('close', () => {
    console.log(`${userID} disconnected`);
    // Remove from waiting list
    const index = waitingPlayers.indexOf(ws);
    if (index !== -1) waitingPlayers.splice(index, 1);

    // Remove matches
    if (userID && matches.has(userID)) {
      const opponent = matches.get(userID);
      if (opponent.readyState === WebSocket.OPEN) {
        opponent.send(JSON.stringify({ type: 'opponent_disconnected' }));
      }
      matches.delete(opponent.userID);
      matches.delete(userID);
    }
  });
});
