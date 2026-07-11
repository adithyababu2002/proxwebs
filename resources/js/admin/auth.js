import { computed, ref } from 'vue';
import axios from 'axios';

const user = ref(null);
const loading = ref(false);

export const isAuthenticated = computed(() => !!user.value);
export const currentUser = computed(() => user.value);
export const authLoading = computed(() => loading.value);

export async function fetchMe() {
    loading.value = true;
    try {
        const { data } = await axios.get('/webuser/api/me');
        user.value = data.user;
        return user.value;
    } catch {
        user.value = null;
        return null;
    } finally {
        loading.value = false;
    }
}

export async function login(payload) {
    const { data } = await axios.post('/webuser/api/login', payload);
    user.value = data.user;
    return data;
}

export async function logout() {
    try {
        await axios.post('/webuser/api/logout');
    } finally {
        user.value = null;
    }
}
