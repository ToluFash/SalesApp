import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        // Add event listener to each row
        this.element.addEventListener('click', () => {
            // Highlight the clicked row
            this.element.classList.toggle('table-active');
        });
    }
}
