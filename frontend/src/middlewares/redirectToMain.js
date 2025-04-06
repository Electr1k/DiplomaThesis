export default function redirectToMain(next, router) {
    console.log(router.redirect)
    router.push({ name: 'dashboard'})
    return next();
}
