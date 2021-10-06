const defaultOptions = {
    baseURL: '/',
    headers: {
        'Content-Type': 'application/json',
    },
}
let _instance = axios.create(defaultOptions);
_instance.interceptors.request.use(function (config) {
    return config;
})

export const instance = _instance
