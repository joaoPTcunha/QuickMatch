function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.innerHTML = '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><line x1="4.5" y1="4.5" x2="19.5" y2="19.5" />';
    } else {
        passwordField.type = 'password';
        eyeIcon.innerHTML = '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3" />';
    }
}