<template>
    <div class="container mx-auto p-6 bg-mailerlite-bg min-h-screen">
        <h1 class="text-3xl font-bold text-mailerlite-text mb-6">MailerLite + Etsy Integration</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-mailerlite-section p-4 rounded-lg shadow">
                <h3 class="text-lg font-bold text-mailerlite-text">Subscribers</h3>
                <p class="text-2xl text-mailerlite-green">{{ subscribers.length }}</p>
            </div>
            <div class="bg-mailerlite-section p-4 rounded-lg shadow">
                <h3 class="text-lg font-bold text-mailerlite-text">Campaigns Sent</h3>
                <p class="text-2xl text-mailerlite-green">{{ campaigns.length }}</p>
            </div>
            <div class="bg-mailerlite-section p-4 rounded-lg shadow">
                <h3 class="text-lg font-bold text-mailerlite-text">Shop Status</h3>
                <p class="text-2xl text-mailerlite-green">{{ shop ? 'Connected' : 'Not Connected' }}</p>
            </div>
        </div>
        <div class="flex space-x-4 mb-6">
            <a href="/api/etsy/auth" class="bg-mailerlite-green text-white px-6 py-3 rounded-lg hover:bg-green-600">Connect Etsy Shop</a>
            <button @click="syncSubscribers" class="bg-mailerlite-green text-white px-6 py-3 rounded-lg hover:bg-green-600">Sync Customers</button>
            <button @click="showCampaignModal = true" class="bg-mailerlite-green text-white px-6 py-3 rounded-lg hover:bg-green-600">Create Campaign</button>
        </div>
        <div class="bg-mailerlite-section p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-bold text-mailerlite-text mb-4">Subscriber Groups</h2>
            <p v-if="shop">{{ shop.mailerlite_group_id ? `Group ID: ${shop.mailerlite_group_id}` : 'No group created' }}</p>
        </div>
        <div class="bg-mailerlite-section p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-bold text-mailerlite-text mb-4">Automations</h2>
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left font-bold text-mailerlite-text">Name</th>
                        <th class="p-3 text-left font-bold text-mailerlite-text">Trigger</th>
                        <th class="p-3 text-left font-bold text-mailerlite-text">Action</th>
                        <th class="p-3 text-left font-bold text-mailerlite-text">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="automation in automations" :key="automation.id" class="bg-mailerlite-bg">
                        <td class="p-3 text-mailerlite-text">{{ automation.name }}</td>
                        <td class="p-3 text-mailerlite-text">{{ automation.trigger }}</td>
                        <td class="p-3 text-mailerlite-text">{{ automation.action }}</td>
                        <td class="p-3 text-mailerlite-text">{{ automation.status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bg-mailerlite-section p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-bold text-mailerlite-text mb-4">Campaign Analytics</h2>
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left font-bold text-mailerlite-text">Campaign</th>
                        <th class="p-3 text-left font-bold text-mailerlite-text">Open Rate</th>
                        <th class="p-3 text-left font-bold text-mailerlite-text">Click Rate</th>
                        <th class="p-3 text-left font-bold text-mailerlite-text">Subscribers Reached</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="campaign in campaigns" :key="campaign.id" class="bg-mailerlite-bg">
                        <td class="p-3 text-mailerlite-text">{{ campaign.title }}</td>
                        <td class="p-3 text-mailerlite-text">{{ campaign.analytics ? campaign.analytics.open_rate : 'N/A' }}</td>
                        <td class="p-3 text-mailerlite-text">{{ campaign.analytics ? campaign.analytics.click_rate : 'N/A' }}</td>
                        <td class="p-3 text-mailerlite-text">{{ campaign.analytics ? campaign.analytics.subscribers_reached : 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="bg-mailerlite-section p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold text-mailerlite-text mb-4">Subscribers</h2>
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-3 text-left font-bold text-mailerlite-text">Email</th>
                        <th class="p-3 text-left font-bold text-mailerlite-text">Name</th>
                        <th class="p-3 text-left font-bold text-mailerlite-text">Synced</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="subscriber in subscribers" :key="subscriber.id" class="bg-mailerlite-bg">
                        <td class="p-3 text-mailerlite-text">{{ subscriber.email }}</td>
                        <td class="p-3 text-mailerlite-text">{{ subscriber.name || 'N/A' }}</td>
                        <td class="p-3 text-mailerlite-text">{{ subscriber.synced ? 'Yes' : 'No' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Campaign Modal -->
        <div v-if="showCampaignModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-mailerlite-bg p-6 rounded-lg w-full max-w-3xl">
                <h2 class="text-xl font-bold text-mailerlite-text mb-4">Create MailerLite Campaign</h2>
                <input v-model="campaignTitle" type="text" placeholder="Campaign Title" class="w-full p-2 mb-4 border rounded text-mailerlite-text">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-mailerlite-text">Email Preview (Drag & Drop Style)</h3>
                    <div class="border p-4 bg-mailerlite-section">
                        <VueDraggableNext v-model="products">
                            <div v-for="product in products" :key="product.listing_id" class="flex items-center p-2 border-b cursor-move">
                                <img :src="product.image_url" alt="Product" class="w-16 h-16 mr-4">
                                <div>
                                    <p class="font-semibold text-mailerlite-text">{{ product.title }}</p>
                                    <p class="text-mailerlite-text">${{ product.price }}</p>
                                </div>
                            </div>
                        </VueDraggableNext>
                        <p class="mt-4 text-mailerlite-text">Happy shopping!</p>
                        <p class="text-mailerlite-text">Your Etsy Shop Team</p>
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <button @click="showCampaignModal = false" class="px-4 py-2 text-mailerlite-text">Cancel</button>
                    <button @click="createCampaign" class="bg-mailerlite-green text-white px-4 py-2 rounded hover:bg-green-600">Send Campaign</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { VueDraggableNext } from 'vue-draggable-next';

export default {
    components: {
        VueDraggableNext
    },
    data() {
        return {
            subscribers: [],
            campaigns: [],
            shop: null,
            showCampaignModal: false,
            campaignTitle: '',
            products: [],
            automations: []
        };
    },
    mounted() {
        this.fetchSubscribers();
        this.fetchCampaigns();
        this.fetchShop();
        this.fetchProducts();
        this.fetchAutomations();
    },
    methods: {
        async fetchSubscribers() {
            try {
                const response = await axios.get('/api/subscribers');
                this.subscribers = response.data || [];
            } catch (error) {
                console.error('Error fetching subscribers:', error.response?.data || error.message);
            }
        },
        async fetchCampaigns() {
            try {
                const response = await axios.get('/api/campaigns');
                this.campaigns = response.data || [];
            } catch (error) {
                console.error('Error fetching campaigns:', error.response?.data || error.message);
            }
        },
        async fetchShop() {
            try {
                const response = await axios.get('/api/shop');
                this.shop = response.data;
            } catch (error) {
                console.error('Error fetching shop:', error.response?.data || error.message);
            }
        },
        async fetchProducts() {
            try {
                const response = await axios.get('/api/etsy/products');
                this.products = response.data.results || [];
            } catch (error) {
                console.error('Error fetching products:', error.response?.data || error.message);
            }
        },
        async fetchAutomations() {
            try {
                const response = await axios.get('/api/automations');
                this.automations = response.data || [];
            } catch (error) {
                console.error('Error fetching automations:', error.response?.data || error.message);
            }
        },
        async syncSubscribers() {
            try {
                const response = await axios.post('/api/etsy/sync');
                await Promise.all([this.fetchSubscribers(), this.fetchShop()]);
                alert(response.data.message);
            } catch (error) {
                console.error('Sync failed:', error.response?.data || error.message);
                alert('Sync failed. Check logs.');
            }
        },
        async createCampaign() {
            try {
                const response = await axios.post('/api/etsy/campaign', {
                    title: this.campaignTitle,
                    products: this.products
                });
                await this.fetchCampaigns();
                this.showCampaignModal = false;
                this.campaignTitle = '';
                alert(response.data.message);
            } catch (error) {
                console.error('Campaign creation failed:', error.response?.data || error.message);
                alert('Campaign creation failed: ' + (error.response?.data?.message || error.message));
            }
        }
    }
};
</script>