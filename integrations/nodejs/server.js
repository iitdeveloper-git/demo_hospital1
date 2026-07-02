const express = require('express');
const app = express();
const PORT = 3000;

app.use(express.json());

// Simulated API route for pushing notifications
app.post('/api/push-notification', (req, res) => {
    const { message, channel } = req.body;
    console.log(`Pushing alert [${channel}]: ${message}`);
    
    res.json({
        success: true,
        dispatched_at: new Date().toISOString(),
        message_status: "queued"
    });
});

app.listen(PORT, () => {
    console.log(`AarogyaCare Node.js notifier microservice listening on port ${PORT}`);
});
