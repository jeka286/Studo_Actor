document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('castingModal');
    const successModal = document.getElementById('castingSuccessModal');
    const successOkButton = document.getElementById('castingSuccessOkBtn');
    const openButtons = document.querySelectorAll('[data-open-casting]');
    const closeButton = document.getElementById('closeCastingModal');
    const form = document.getElementById('castingForm');
    const phoneInput = document.getElementById('castingPhone');
    const nameInput = document.getElementById('castingFullname');
    const submitButton = document.getElementById('castingSubmitBtn');

    function openModal() {
        if (!modal) return;
        modal.classList.remove('is-hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.add('is-hidden');
        modal.setAttribute('aria-hidden', 'true');
        if (!successModal || successModal.classList.contains('is-hidden')) {
            document.body.classList.remove('modal-open');
        }
    }

    function openSuccessModal() {
        if (!successModal) return;
        successModal.classList.remove('is-hidden');
        successModal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
    }

    function closeSuccessModal() {
        if (!successModal) return;
        successModal.classList.add('is-hidden');
        successModal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    openButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            openModal();
        });
    });

    if (closeButton) {
        closeButton.addEventListener('click', closeModal);
    }

    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    if (form) {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const phone = phoneInput ? phoneInput.value.trim() : '';
            const fullname = nameInput ? nameInput.value.trim() : '';

            if (!phone) {
                alert('Пожалуйста, введите номер телефона');
                if (phoneInput) phoneInput.focus();
                return;
            }

            if (!fullname) {
                alert('Пожалуйста, введите ФИО');
                if (nameInput) nameInput.focus();
                return;
            }

            const formData = new FormData(form);

            try {
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Отправка...';
                }

                const response = await fetch('casting_submit.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Не удалось отправить заявку');
                }

                form.reset();
                closeModal();
                openSuccessModal();
            } catch (error) {
                alert(error.message || 'Ошибка при отправке заявки');
            } finally {
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Отправить';
                }
            }
        });
    }

    if (successOkButton) {
        successOkButton.addEventListener('click', closeSuccessModal);
    }

    if (successModal) {
        successModal.addEventListener('click', function (event) {
            if (event.target === successModal) {
                closeSuccessModal();
            }
        });
    }
});
