<div id="profileModal" class="profile-modal-overlay is-hidden" aria-hidden="true">
    <div class="profile-modal-card" role="dialog" aria-modal="true" aria-labelledby="profileModalTitle">
        <button type="button" class="profile-modal-close" id="closeProfileModal" aria-label="Закрыть">&times;</button>

        <div class="profile-modal-header">
            <div class="profile-modal-badge">
                <img src="../Style/Global/default-avatar.svg" alt="Avatar">
            </div>
            <h2 id="profileModalTitle" class="profile-modal-title">Личный кабинет</h2>
            <p class="profile-modal-subtitle">Редактируйте данные профиля</p>
        </div>

        <form id="profileForm" class="profile-modal-form">
            <div class="profile-modal-field">
                <label for="profileFullName">ФИО</label>
                <input type="text" id="profileFullName" name="full_name" value="<?php echo htmlspecialchars($user_data['full_name'] ?? ''); ?>" required>
            </div>

            <div class="profile-modal-field">
                <label for="profileEmail">Email</label>
                <input type="email" id="profileEmail" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
            </div>

            <div class="profile-modal-field">
                <label for="profilePhone">Телефон</label>
                <input type="tel" id="profilePhone" name="phone" value="<?php echo htmlspecialchars($user_data['phone'] ?? ''); ?>" placeholder="+7 (___) ___-__-__">
            </div>

            <div class="profile-modal-note">
                Аватар для всех пользователей одинаковый и не редактируется.
            </div>

            <button type="submit" class="profile-modal-submit" id="profileSubmitBtn">Сохранить</button>
        </form>
    </div>
</div>

<script src="../Scripts/profile-modal.js"></script>
