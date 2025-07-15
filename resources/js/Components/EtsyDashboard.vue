<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold text-blue-600">MailerLite-Etsy Integration</h1>
        <a href="/api/etsy/auth" class="bg-blue-600 text-white px-4 py-2 rounded mt-4 inline-block">Connect Etsy Shop</a>
        <button @click="syncSubscribers" class="bg-blue-600 text-white px-4 py-2 rounded mt-4 ml-2">Sync Etsy Customers</button>
        <table class="mt-4 w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Email</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Synced</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="subscriber in subscribers" :key="subscriber.id">
                    <td class="p-2">{{ subscriber.email }}</td>
                    <td class="p-2">{{ subscriber.name || 'N/A' }}</td>
                    <td class="p-2">{{ subscriber.synced ? 'Yes' : 'No' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            subscribers: []
        };
    },
    mounted() {
        this.fetchSubscribers();
    },
    methods: {
        async fetchSubscribers() {
            try {
                const response = await axios.get('/api/subscribers');
                this.subscribers = response.data;
            } catch (error) {
                console.error('Error fetching subscribers:', error);
            }
        },
        async syncSubscribers() {
            try {
                await axios.post('/api/etsy/sync');
                await this.fetchSubscribers();
                alert('Sync completed!');
            } catch (error) {
                console.error('Sync failed:', error);
                alert('Sync failed. Check logs.');
            }
        }
    }
};
</script>

<style>
.container {
    font-family: 'Arial', sans-serif;
}
.text-blue-600 {
    color: #00A8E8; /* MailerLite blue */
}
.bg-blue-600 {
    background-color: #00A8E8;
}
</style>