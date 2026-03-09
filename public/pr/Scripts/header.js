class MyHeader extends HTMLElement {
    connectedCallback() {
        this.innerHTML = `
        <header class="main-header">
            <div class="header-container">
                <h1 class="studio-title">STUDIO ACTOR</h1>
                <div class="auth-buttons">
                    <a href="#" class="btn">Вход</a>
                    <a href="#" class="btn">Регистрация</a>
                </div>
            </div>
        </header>
        `;
    }
}

customElements.define('my-header', MyHeader);