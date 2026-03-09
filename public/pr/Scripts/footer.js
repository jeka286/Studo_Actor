// footer.js
class FooterComponent {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.init();
    }

    init() {
        if (this.container) {
            this.render();
        }
    }

    render() {
        this.container.innerHTML = `
            <footer class="footer">
                <div class="footer__container">
                    <h3 class="footer__title">Studio actor</h3>
                    <p class="footer__subtitle">Вдохновлять вас и помогать вашему таланту расти</p>
                    
                    <div class="footer__grid">
                        <div class="footer__column">
                            <h4 class="footer__column-title">О проекте</h4>
                            <ul class="footer__links">
                                <li><a href="#">Как это работает</a></li>
                                <li><a href="#">Популярное</a></li>
                                <li><a href="#">Сотрудничество</a></li>
                            </ul>
                        </div>
                        
                        <div class="footer__column">
                            <h4 class="footer__column-title">Сообщество</h4>
                            <ul class="footer__links">
                                <li><a href="#">События</a></li>
                                <li><a href="#">Блог</a></li>
                            </ul>
                        </div>
                        
                        <div class="footer__column">
                            <h4 class="footer__column-title">Соцсети</h4>
                            <ul class="footer__links">
                                <li><a href="#">Discord</a></li>
                                <li><a href="#">Instagram</a></li>
                                <li><a href="#">Telegram</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="footer__bottom">
                        <p>StyleGuide © 2024</p>
                    </div>
                </div>
            </footer>
        `;
    }
}

// Автоматическая инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('footer-component')) {
        new FooterComponent('footer-component');
    }
});