document.addEventListener('DOMContentLoaded', (event) => {
    const yearSpan = document.getElementById('year');
    if (yearSpan) {
        const currentYear = new Date().getFullYear();
        yearSpan.textContent = currentYear;
    }
});

function updateClassBasedOnWidth() {
    const carouselItems = document.getElementById('carousel-items');

    if (!carouselItems) {
        return;
    }

    const width = window.innerWidth;

    if (width < 768) { // Mobile
        carouselItems.className = 'uk-slider-items uk-child-width-1-1 uk-grid';
    } else if (width >= 768 && width < 1024) { // Tablets
        carouselItems.className = 'uk-slider-items uk-child-width-1-2 uk-grid';
    } else { // Desktop
        carouselItems.className = 'uk-slider-items uk-child-width-1-3 uk-grid';
    }
}

// Initial check
updateClassBasedOnWidth();

// Update on resize
window.addEventListener('resize', updateClassBasedOnWidth);