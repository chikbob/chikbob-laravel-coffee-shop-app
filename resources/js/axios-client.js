import axios from 'axios';

const axiosClient = axios.create({
    baseURL: `${import.meta.env.VITE_BASE_URL_APP ?? ''}/api`,
    withCredentials: false, // public requests; если используешь sanctum with cookies — см. ниже
});

// добавляем токен из localStorage как Bearer (если нужен)
axiosClient.interceptors.request.use(config => {
    const token = localStorage.getItem('ACCESS_TOKEN');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

axiosClient.interceptors.response.use(response => response, error => {
    const { response } = error;
    if (response && response.status === 401) {
        localStorage.removeItem('ACCESS_TOKEN');
    }
    return Promise.reject(error);
});

export default axiosClient;
