document.addEventListener('DOMContentLoaded', function() {
    const gallery = document.getElementById('gallery');
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const closeBtn = document.getElementById('closeBtn');

    // Function to fetch random sewing machine images
    async function fetchImages() {
        try {
            const response = await fetch('https://api.unsplash.com/photos/random?query=sewing+machine&count=6&client_id=6eXDvUonrWdNO9_0VuNk72RUcoMJQ5F153j2trZ2K8c');
            const images = await response.json();

            images.forEach(img => {
                const galleryItem = document.createElement('div');
                galleryItem.className = 'gallery-item';
                galleryItem.tabIndex = 0;
                galleryItem.innerHTML = `<img src="${img.urls.small}" alt="Gallery Image">`;
                gallery.appendChild(galleryItem);
            });

            // Add event listeners for the new gallery items
            document.querySelectorAll('.gallery-item').forEach(item => {
                item.addEventListener('click', () => {
                    const imgSrc = item.querySelector('img').src;
                    lightboxImg.src = imgSrc;
                    lightbox.style.display = 'flex';
                });
            });

        } catch (error) {
            console.error('Error fetching images:', error);
        }
    }

    // Fetch images when the page loads
    fetchImages();

    closeBtn.addEventListener('click', () => {
        lightbox.style.display = 'none';
    });

    lightbox.addEventListener('click', (e) => {
        if (e.target !== lightboxImg) {
            lightbox.style.display = 'none';
        }
    });
});
