import { createServer } from 'node:http';
import { readFile } from 'node:fs/promises';
import { networkInterfaces } from 'node:os';
import path from 'node:path';

const root = process.cwd();
const port = Number(process.env.PORT ?? 4173);
const host = process.env.HOST ?? '0.0.0.0';
const types = {
    '.css': 'text/css; charset=utf-8',
    '.js': 'text/javascript; charset=utf-8',
    '.html': 'text/html; charset=utf-8',
    '.txt': 'text/plain; charset=utf-8',
    '.xml': 'application/xml; charset=utf-8',
    '.png': 'image/png',
    '.jpg': 'image/jpeg',
    '.jpeg': 'image/jpeg',
    '.webp': 'image/webp',
    '.svg': 'image/svg+xml',
    '.json': 'application/json; charset=utf-8',
};

function getNetworkUrls() {
    return Object.values(networkInterfaces())
        .flat()
        .filter((item) => item && item.family === 'IPv4' && !item.internal)
        .map((item) => `http://${item.address}:${port}`);
}

const server = createServer(async (request, response) => {
    try {
        const url = new URL(request.url ?? '/', `http://127.0.0.1:${port}`);
        let pathname = url.pathname === '/' ? '/public/preview.html' : url.pathname;
        if (pathname === '/favicon.svg') {
            pathname = '/public/favicon.svg';
        } else if (pathname.startsWith('/images/')) {
            pathname = `/public${pathname}`;
        } else if (pathname === '/about') {
            pathname = '/public/about.html';
        } else if (pathname === '/booking') {
            pathname = '/public/booking.html';
        } else if (pathname === '/contact') {
            pathname = '/public/contact.html';
        } else if (pathname === '/clients') {
            pathname = '/public/clients.html';
        } else if (pathname === '/services') {
            pathname = '/public/services.html';
        } else if (pathname === '/services/angioplasty-stenting') {
            pathname = '/public/services/angioplasty-stenting.html';
        } else if (pathname === '/doctors') {
            pathname = '/public/doctors.html';
        } else if (pathname === '/doctors/dr-aanya-sharma') {
            pathname = '/public/doctors/dr-aanya-sharma.html';
        }

        const filePath = path.join(root, pathname);
        const data = await readFile(filePath);
        response.writeHead(200, { 'Content-Type': types[path.extname(filePath)] ?? 'application/octet-stream' });
        response.end(data);
    } catch {
        response.writeHead(404, { 'Content-Type': 'text/plain; charset=utf-8' });
        response.end('Not found');
    }
});

server.listen(port, host, () => {
    const networkUrls = getNetworkUrls();
    console.log(`AarogyaCare preview running:`);
    console.log(`  Local:   http://127.0.0.1:${port}`);
    networkUrls.forEach((url) => console.log(`  Network: ${url}`));
    if (!networkUrls.length) {
        console.log('  Network: connect this computer to Wi-Fi/LAN to get a phone/tablet URL.');
    }
});


