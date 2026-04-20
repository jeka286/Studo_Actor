<div id="castingModal" class="casting-modal-overlay is-hidden" aria-hidden="true">
    <div class="casting-modal-card" role="dialog" aria-modal="true" aria-labelledby="castingModalTitle">
        <button type="button" class="casting-modal-close" id="closeCastingModal" aria-label="Закрыть">&times;</button>

        <div class="casting-modal-header">
            <h2 id="castingModalTitle" class="casting-modal-title">Кастинг</h2>
            <p class="casting-modal-subtitle">Заполните форму для кастинга</p>
        </div>

        <form id="castingForm" class="casting-modal-form">
            <div class="casting-modal-field">
                <input type="tel" id="castingPhone" name="phone" placeholder="Введите номер телефона (+7)" required>
            </div>

            <div class="casting-modal-field">
                <input type="text" id="castingFullname" name="fullname" placeholder="ФИО" required>
            </div>

            <p class="casting-modal-helper">с вами свяжется наш оператор</p>

            <button type="submit" class="casting-modal-submit" id="castingSubmitBtn">Отправить</button>
        </form>
    </div>
</div>

<div id="castingSuccessModal" class="casting-success-overlay is-hidden" aria-hidden="true">
    <div class="casting-success-card" role="dialog" aria-modal="true" aria-labelledby="castingSuccessTitle">
        <div class="casting-success-icon">✓</div>
        <h3 id="castingSuccessTitle" class="casting-success-title">Спасибо!</h3>
        <p class="casting-success-text">Ваша заявка успешно отправлена. В ближайшее время мы с вами свяжемся!</p>
        <button type="button" class="casting-success-button" id="castingSuccessOkBtn">ok</button>
    </div>
</div>

<script src="../Scripts/casting-modal.js"></script>
