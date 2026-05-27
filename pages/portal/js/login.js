/**
 * login.js — Portal Login Page
 * Phulpur Mohila Degree College
 */

'use strict';

/* ── Current year ─────────────────────────────────────────── */
document.querySelectorAll('#currentYear, .year-val')
    .forEach(el => el.textContent = new Date().getFullYear());

/* ── DOM refs ──────────────────────────────────────────────── */
const stepSelect  = document.getElementById('step-select');
const stepLogin   = document.getElementById('step-login');
const portalCards = document.querySelectorAll('.pcard');

const portalIdBar = document.getElementById('portalIdBar');
const pidIcon     = document.getElementById('pidIcon');
const pidLabel    = document.getElementById('pidLabel');

const btnChangePortal = document.getElementById('btnChangePortal');
const btnBack         = document.getElementById('btnBack');

const loginForm    = document.getElementById('loginForm');
const usernameInput= document.getElementById('username');
const passwordInput= document.getElementById('password');
const togglePass   = document.getElementById('togglePass');
const togglePassIcon= document.getElementById('togglePassIcon');
const btnSignIn    = document.getElementById('btnSignIn');
const loginError   = document.getElementById('loginError');
const loginErrorMsg= document.getElementById('loginErrorMsg');
const errUsername  = document.getElementById('err-username');
const errPassword  = document.getElementById('err-password');

/* Destination href once authenticated (set on portal select) */
let selectedDest = '';

/* ── Demo credentials (replace with real auth) ───────────── */
const CREDENTIALS = {
    teacher: { username: 'teacher', password: 'pmdc2024' },
    admin:   { username: 'admin',   password: 'pmdc@admin' },
};
let selectedPortal = '';

/* ── STEP 1 → STEP 2: portal selection ──────────────────── */
function goToLogin(card) {
    selectedPortal = card.dataset.portal;  // 'teacher' | 'admin'
    selectedDest   = card.dataset.dest;
    const color    = card.dataset.color;   // 'blue' | 'purple'
    const label    = card.dataset.label;
    const iconCls  = card.dataset.icon;

    // Update portal identity bar
    pidIcon.className   = `pid-icon ${color}`;
    pidIcon.innerHTML   = `<i class="fas ${iconCls}"></i>`;
    pidLabel.textContent = label;
    portalIdBar.className = `portal-id-bar accent-${color}`;

    // Colour the sign-in button
    btnSignIn.classList.toggle('purple-btn', color === 'purple');

    // Reset form state
    loginForm.reset();
    clearErrors();
    loginError.classList.remove('visible');

    // Transition
    stepSelect.classList.add('step--hidden');
    stepLogin.classList.remove('step--hidden');
    stepLogin.style.animation = 'none';
    requestAnimationFrame(() => {
        stepLogin.style.animation = '';
        stepLogin.style.animationName = 'fadeUp';
        stepLogin.style.animationDuration = '.34s';
        stepLogin.style.animationFillMode = 'both';
    });

    // Focus username
    setTimeout(() => usernameInput.focus(), 80);
}

portalCards.forEach(card => {
    card.addEventListener('click', () => goToLogin(card));
    card.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); goToLogin(card); }
    });
});

/* ── STEP 2 → STEP 1: go back ───────────────────────────── */
function goBack() {
    stepLogin.classList.add('step--hidden');
    stepSelect.classList.remove('step--hidden');
    stepSelect.style.animation = 'none';
    requestAnimationFrame(() => {
        stepSelect.style.animation = '';
        stepSelect.style.animationName = 'fadeUp';
        stepSelect.style.animationDuration = '.34s';
        stepSelect.style.animationFillMode = 'both';
    });
}
btnBack?.addEventListener('click', goBack);
btnChangePortal?.addEventListener('click', goBack);

/* ── Password toggle ─────────────────────────────────────── */
togglePass?.addEventListener('click', () => {
    const isPass = passwordInput.type === 'password';
    passwordInput.type = isPass ? 'text' : 'password';
    togglePassIcon.className = isPass ? 'fas fa-eye-slash' : 'fas fa-eye';
});

/* ── Validation helpers ──────────────────────────────────── */
function setErr(input, errEl, msg) {
    input.style.borderColor = msg ? 'var(--red)' : '';
    errEl.textContent = msg;
}
function clearErrors() {
    setErr(usernameInput, errUsername, '');
    setErr(passwordInput, errPassword, '');
}
function validate() {
    let ok = true;
    if (!usernameInput.value.trim()) {
        setErr(usernameInput, errUsername, 'Username is required.');
        ok = false;
    } else {
        setErr(usernameInput, errUsername, '');
    }
    if (!passwordInput.value.trim()) {
        setErr(passwordInput, errPassword, 'Password is required.');
        ok = false;
    } else {
        setErr(passwordInput, errPassword, '');
    }
    return ok;
}

/* Clear field error on typing */
usernameInput?.addEventListener('input', () => setErr(usernameInput, errUsername, ''));
passwordInput?.addEventListener('input', () => setErr(passwordInput, errPassword, ''));

/* ── Form submit / auth ──────────────────────────────────── */
loginForm?.addEventListener('submit', e => {
    e.preventDefault();
    loginError.classList.remove('visible');

    if (!validate()) return;

    // Loading state
    btnSignIn.classList.add('loading');

    // Simulate network delay — replace with real fetch/AJAX for PHP auth
    setTimeout(() => {
        btnSignIn.classList.remove('loading');

        const creds = CREDENTIALS[selectedPortal];
        const uOk   = usernameInput.value.trim() === creds?.username;
        const pOk   = passwordInput.value         === creds?.password;

        if (uOk && pOk) {
            // ✅ Success — redirect to portal
            btnSignIn.classList.add('loading'); // keep loading during redirect
            window.location.href = selectedDest;
        } else {
            // ❌ Wrong credentials
            loginErrorMsg.textContent = 'Invalid username or password. Please try again.';
            loginError.classList.add('visible');
            passwordInput.value = '';
            passwordInput.focus();
        }
    }, 900);
});