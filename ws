#!/usr/bin/python
import asyncio
import json
import websockets

class MyWebSocketServer:
    def __init__(self, host='192.168.1.213', port=8765):
        self.host = host
        self.port = port
        self.clients = set()

    async def broadcast(self, message):
        if self.clients:
            await asyncio.wait([client.send(message) for client in self.clients])

    async def process_command(self, command):
        # Replace this with your own command processing logic
        if command['action'] == 'print':
            print(command['message'])
        elif command['action'] == 'add':
            result = command['x'] + command['y']
            print(f"{command['x']} + {command['y']} = {result}")

    async def handle_client(self, websocket, path):
        self.clients.add(websocket)
        try:
            async for message in websocket:
                command = json.loads(message)
                await self.process_command(command)
        finally:
            self.clients.remove(websocket)

    async def start(self):
        async with websockets.serve(self.handle_client, self.host, self.port):
            print(f"WebSocket server listening on {self.host}:{self.port}")
            await asyncio.Future()  # Run forever

if __name__ == '__main__':
    server = MyWebSocketServer()
    asyncio.run(server.start())
