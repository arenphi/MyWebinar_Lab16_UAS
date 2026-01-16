const loginPass = document.getElementById('login-pass'),
    loginEye = document.getElementById('login-eye')

loginEye.addEventListener('click', () => {
        if (loginPass.type === 'password') {
            loginPass.type = 'text'
            loginEye.classList.add('ri-eye-line')
            loginEye.classList.remove('ri-eye-off-line')
        } else {
            loginPass.type = 'password'
            loginEye.classList.remove('ri-eye-line')
            loginEye.classList.add('ri-eye-off-line')
        }
    })
    /* Password Toggle */
const regPass = document.getElementById('reg-pass'),
    regEye = document.getElementById('reg-eye')

regEye.addEventListener('click', () => {
    if (regPass.type === 'password') {
        regPass.type = 'text'
        regEye.classList.add('ri-eye-line')
        regEye.classList.remove('ri-eye-off-line')
    } else {
        regPass.type = 'password'
        regEye.classList.remove('ri-eye-line')
        regEye.classList.add('ri-eye-off-line')
    }
})