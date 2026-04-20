document.addEventListener('DOMContentLoaded', function () {
    const profileModal = document.getElementById('profileModal');
    const openButtons = document.querySelectorAll('[data-open-profile]');
    const closeButton = document.getElementById('closeProfileModal');
    const form = document.getElementById('profileForm');
    const submitButton = document.getElementById('profileSubmitBtn');
    const fullNameInput = document.getElementById('profileFullName');
    const emailInput = document.getElementById('profileEmail');
    const phoneInput = document.getElementById('profilePhone');
    const displayName = document.querySelector('[data-user-fullname]');
    const displayEmail = document.querySelector('[data-user-email]');

    function openModal() {
        if (!profileModal) return;
        profileModal.classList.remove('is-hidden');
        profileModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
    }

    function closeModal() {
        if (!profileModal) return;
        profileModal.classList.add('is-hidden');
        profileModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    openButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            openModal();
        });
    });

    if (closeButton) {
        closeButton.addEventListener('click', closeModal);
    }

    if (profileModal) {
        profileModal.addEventListener('click', function (event) {
            if (event.target === profileModal) {
                closeModal();
            }
        });
    }

    if (form) {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const fullName = fullNameInput ? fullNameInput.value.trim() : '';
            const email = emailInput ? emailInput.value.trim() : '';
            const phone = phoneInput ? phoneInput.value.trim() : '';

            if (!fullName || !email) {
                alert('Заполните ФИО и email');
                return;
            }

            try {
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Сохранение...';
                }

                const formData = new FormData(form);
                const response = await fetch('profile_update.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Не удалось сохранить профиль');
                }

                if (displayName) {
                    displayName.textContent = result.full_name || fullName;
                }
                if (displayEmail) {
                    displayEmail.textContent = result.email || email;
                }
                if (phoneInput && typeof result.phone === 'string') {
                    phoneInput.value = result.phone;
                }

                closeModal();
                alert(result.message || 'Профиль сохранен');
            } catch (error) {
                alert(error.message || 'Ошибка при сохранении профиля');
            } finally {
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Сохранить';
                }
            }
        });
    }
});
