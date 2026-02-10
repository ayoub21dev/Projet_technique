import ContactsManager from './Alpine/components/ContactsManager';

const registerContactsManager = () => {
    const Alpine = window.Alpine;
    if (!Alpine || window.__contactsManagerRegistered) return;

    Alpine.data('contactsManager', ContactsManager);

    window.__contactsManagerRegistered = true;
    console.log('ContactsManager registered successfully', window.Alpine);
};

if (window.Alpine) {
    registerContactsManager();
} else {
    document.addEventListener('alpine:init', registerContactsManager, { once: true });
}
