const table = document.getElementById('contacts-table');
const modal = document.getElementById('contactModal');

// 1. Recherche
document.getElementById('search')?.addEventListener('input', e => {
    fetch(`${window.CONTACT_ROUTES.search}?query=${e.target.value}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => table.innerHTML = html);
});

// 2. Ajout
document.getElementById('contactForm')?.addEventListener('submit', e => {
    e.preventDefault();
    fetch(e.target.action, {
        method: 'POST',
        body: new FormData(e.target),
        headers: { 
            'X-Requested-With': 'XMLHttpRequest', 
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            modal.classList.add('hidden');
            e.target.reset();
            document.getElementById('success-msg').innerText = data.message;
            document.getElementById('search').dispatchEvent(new Event('input'));
        }
    });
});

// 3. Modal
document.getElementById('openModal')?.addEventListener('click', () => modal.classList.remove('hidden'));
document.querySelectorAll('.close-btn')?.forEach(btn => btn.addEventListener('click', () => modal.classList.add('hidden')));
