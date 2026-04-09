const API_BASE = window.location.pathname.includes('/pages/') ? '../../' : './';

const API = {
    async fetch(url, options = {}) {
        const defaultHeaders = {
            'Content-Type': 'application/json',
        };
        
        try {
            const response = await fetch(url, {
                ...options,
                headers: {
                    ...defaultHeaders,
                    ...options.headers,
                },
            });
            
            const data = await response.json();
            if (!data.success) {
                // If unauthorized and not on auth pages, redirect to login
                if (data.message === "Authentication required." && !window.location.pathname.includes('auth/')) {
                    const loginPath = window.location.pathname.includes('/pages/') ? '../auth/login.php' : 'pages/auth/login.php';
                    window.location.href = loginPath;
                }
            }
            return data;
        } catch (error) {
            console.error('API Error:', error);
            return { success: false, message: 'Network error or server down.' };
        }
    },

    auth: {
        async register(username, email, password) {
            return await API.fetch(API_BASE + 'api/auth.php?action=register', {
                method: 'POST',
                body: JSON.stringify({ username, email, password })
            });
        },
        async login(email, password) {
            return await API.fetch(API_BASE + 'api/auth.php?action=login', {
                method: 'POST',
                body: JSON.stringify({ email, password })
            });
        },
        async logout() {
            return await API.fetch(API_BASE + 'api/auth.php?action=logout');
        },
        async status() {
            return await API.fetch(API_BASE + 'api/auth.php?action=status');
        },
        async updateProfile(username, email) {
            return await API.fetch(API_BASE + 'api/auth.php?action=update_profile', {
                method: 'POST',
                body: JSON.stringify({ username, email })
            });
        }
    },

    analytics: {
        async get() {
            return await API.fetch(API_BASE + 'api/analytics.php');
        }
    },

    prompts: {
        async list() {
            return await API.fetch(API_BASE + 'api/prompts.php?action=list');
        },
        async public() {
            return await API.fetch(API_BASE + 'api/prompts.php?action=public');
        },
        async get(id) {
            return await API.fetch(API_BASE + `api/prompts.php?action=get&id=${id}`);
        },
        async create(promptData) {
            return await API.fetch(API_BASE + 'api/prompts.php?action=create', {
                method: 'POST',
                body: JSON.stringify(promptData)
            });
        },
        async update(promptData) {
            return await API.fetch(API_BASE + 'api/prompts.php?action=update', {
                method: 'POST',
                body: JSON.stringify(promptData)
            });
        },
        async delete(id) {
            return await API.fetch(API_BASE + 'api/prompts.php?action=delete', {
                method: 'POST',
                body: JSON.stringify({ id })
            });
        }
    },

    categories: {
        async list() {
            return await API.fetch(API_BASE + 'api/categories.php?action=list');
        },
        async create(name) {
            return await API.fetch(API_BASE + 'api/categories.php?action=create', {
                method: 'POST',
                body: JSON.stringify({ name })
            });
        },
        async delete(id) {
            return await API.fetch(API_BASE + 'api/categories.php?action=delete', {
                method: 'POST',
                body: JSON.stringify({ id })
            });
        }
    }
};
