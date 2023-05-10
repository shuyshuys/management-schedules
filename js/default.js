class Footer extends HTMLElement {
    connectedCallback() {
        this.innerHTML =
            `<div class="container">
            <div class="row">
                <div class="col-md-11 text-center">
                    <p>&copy;2023 All Rights Reserved by <a href="https://www.github.com/shuyshuys/" target="_blank">Shuya Setsuna</a></p>
                </div>
                <div class="col-md-1 text-right">
                    <a href="https://id.linkedin.com/in/ahmyaz-id"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="https://instagram.com/shuyshuys"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
            </div>`
    }
}

customElements.define('reserved-by', Footer);