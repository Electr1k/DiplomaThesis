export default function redirectToMain(next, router) {
    if (localStorage.getItem('auth_token')) router.push({ name: 'dashboard'})
    return next();
}
