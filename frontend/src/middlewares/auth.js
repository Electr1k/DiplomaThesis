export default function auth(next, router) {
    const token = localStorage.getItem('auth_token');

    if (!token) {
        console.log(router)
        return router.push({ name: 'login' });
    }

    return next();
}
