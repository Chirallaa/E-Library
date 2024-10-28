const menuToggle = document.querySelector('.guest-menu-toggle');
const closeBtn = document.querySelector('.guest-close-btn');
const menu = document.querySelector('.guest-menu');

menuToggle.addEventListener('click', function() {
    menu.classList.toggle('open');
    if (menu.classList.contains('open')) {
        menuToggle.style.display = 'none'; // Sembunyikan tombol "="
    }
});

closeBtn.addEventListener('click', function() {
    menu.classList.remove('open');
    menuToggle.style.display = 'block'; // Tampilkan kembali tombol "="
});


//-- sidebar -->
document.addEventListener('DOMContentLoaded', function() {
    var filterLinks = document.querySelectorAll('.filter-link');
    filterLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var value = this.getAttribute('data-value');
            window.location.href = '/?query=' + encodeURIComponent(value);
        });
    });

    // Kode untuk collapsible sidebar
    var collapsibles = document.querySelectorAll('.sidebar-section h3.collapsible');
    collapsibles.forEach(function(collapsible) {
        collapsible.addEventListener('click', function() {
            this.classList.toggle('active');
            var content = this.nextElementSibling;
            var toggleIcon = this.querySelector('.toggle-icon');
            
            if (content.style.display === 'none' || content.style.display === '') {
                content.style.display = 'block';
            } else {
                content.style.display = 'none';
            }
        });
    });
});

//-- carousel
document.addEventListener('DOMContentLoaded', function() {
    var carousel = document.querySelector('#yourCarouselId');
    var carouselInstance = new bootstrap.Carousel(carousel, {
        interval: 3000, // Change slide every 5 seconds
        wrap: true, // Continuously loop
        pause: false, // Don't pause on hover
        fade: true // Use fade transition instead of slide
    });

    // Add smooth scrolling effect
    carousel.addEventListener('slide.bs.carousel', function (e) {
        var activeItem = this.querySelector('.active');
        var nextItem = e.relatedTarget;
        
        activeItem.style.transition = 'opacity 1.5s ease-in-out';
        nextItem.style.transition = 'opacity 1.5s ease-in-out';
        
        activeItem.style.opacity = 0;
        nextItem.style.opacity = 1;
    });
});


function animateCount(element, target, id) {
    let current = 0;
    const duration = 1000; // Animation duration in milliseconds
    const step = target / (duration / 16); // 60 FPS

    const animate = () => {
        current += step;
        if (current < target) {
            document.getElementById(id).innerText = Math.round(current);
            requestAnimationFrame(animate);
        } else {
            document.getElementById(id).innerText = target;
        }
    };

    animate();
}