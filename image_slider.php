<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automatic Image Slider</title>
    <style>
        /* Style for the slider container */
        .slider-container {
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        /* Style for the images in the slider */
        .slider-image {
            width: 100%;
            display: none;
        }

        /* Style for the next/previous buttons */
        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            cursor: pointer;
            z-index: 100;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* Position the previous button on the left side */
        .prev {
            left: 10px;
        }

        /* Position the next button on the right side */
        .next {
            right: 10px;
        }
    </style>
</head>
<body>
    <div class="slider-container">
        <!-- Images -->
        <img class="slider-image" src="beanne.jpg" alt="Image 1">
        <img class="slider-image" src="image2.jpg" alt="Image 2">
        <img class="slider-image" src="image3.jpg" alt="Image 3">
        
        <!-- Previous and Next buttons -->
        <button class="prev" onclick="plusSlides(-1)">❮</button>
        <button class="next" onclick="plusSlides(1)">❯</button>
    </div>

    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName("slider-image");
            
            // Hide all slides
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            // Increment slideIndex
            slideIndex++;

            // Reset slideIndex if it exceeds the number of slides
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            // Display the current slide
            slides[slideIndex - 1].style.display = "block";

            // Call showSlides() again after 2 seconds
            setTimeout(showSlides, 2000); // Change slide every 2 seconds
        }

        // Function to navigate to the previous or next slide
        function plusSlides(n) {
            slideIndex += n;
            showSlides();
        }
    </script>
</body>
</html>
