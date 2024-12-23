<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
body{
    background-color: white;
    font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

#heading{
    margin: 50px 0;
    text-align: center;
    color: #181C14;
}

.container {
    padding: 0 10%;
}

.container p {
    padding: 50px 0;
    font-size: 18px;
    margin-bottom: 20px;
    color: #5a5a5a;
}

.rating-box header {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 15px;
    color: #1b1b1b;
}


.stars {
    gap: 8px;
}


.stars button {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
}


.stars img {
    width: 35px; 
    height: 35px;
    transition: transform 0.2s;
}

.stars button:hover img {
    transform: scale(1.2); 
}

.feedback{
    margin: 20px 0;
}

#feedback-text{
    font-size: 18px;;
    border-radius: 5px;
    width: 100%;
}

#submit-button{
    font-size: 18px;
    margin-top: 10px;
    max-width: 160px;;
}
    </style>
</head>
<body>
    <div class="container">
        <p>You have reached your destination in 16 minutes</p>

        <div class="rating-box">
            <header>Please rate your driver</header>
            <div class="stars">
                <button onclick="rating(1)" id="one"><img src="images/darkstar.png"></button>
                <button onclick="rating(2)" id="two"><img src="images/darkstar.png"></button>
                <button onclick="rating(3)" id="three"><img src="images/darkstar.png"></button>
                <button onclick="rating(4)" id="four"><img src="images/darkstar.png"></button>
                <button onclick="rating(5)" id="five"><img src="images/darkstar.png"></button>
            </div>
        </div>

        <div class="feedback">
            <form>
                <textarea id="feedback-text" type="text" placeholder="Write your feedback here" 
                maxlength="255" rows="10"></textarea>
                <button id ="submit-button" type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        let stars = document.querySelector(".stars");
        let clicked = 0;
        let selection = 0;

        function rating(rating){

            if(clicked === 1 && selection === rating){
                stars.innerHTML = `<button onclick="rating(1)" id="one"><img src="images/darkstar.png"></button>
                        <button onclick="rating(2)" id="two"><img src="images/darkstar.png"></button>
                        <button onclick="rating(3)" id="three"><img src="images/darkstar.png"></button>
                        <button onclick="rating(4)"id="four"><img src="images/darkstar.png"></button>
                        <button onclick="rating(5)" id="five"><img src="images/darkstar.png"></button>`;
                clicked = 0;
            }
            else if(rating === 1){
                stars.innerHTML = `<button onclick="rating(1)" id="one"><img src="images/star.png"></button>
                        <button onclick="rating(2)" id="two"><img src="images/darkstar.png"></button>
                        <button onclick="rating(3)" id="three"><img src="images/darkstar.png"></button>
                        <button onclick="rating(4)"id="four"><img src="images/darkstar.png"></button>
                        <button onclick="rating(5)" id="five"><img src="images/darkstar.png"></button>`;
                clicked = 1;
                selection = 1;
            }
            else if(rating === 2){
                stars.innerHTML = `<button onclick="rating(1)" id="one"><img src="images/star.png"></button>
                        <button onclick="rating(2)" id="two"><img src="images/star.png"></button>
                        <button onclick="rating(3)" id="three"><img src="images/darkstar.png"></button>
                        <button onclick="rating(4)"id="four"><img src="images/darkstar.png"></button>
                        <button onclick="rating(5)" id="five"><img src="images/darkstar.png"></button>`;
                clicked = 1;
                selection = 2;
            }
            else if(rating === 3){
                stars.innerHTML = `<button onclick="rating(1)" id="one"><img src="images/star.png"></button>
                        <button onclick="rating(2)" id="two"><img src="images/star.png"></button>
                        <button onclick="rating(3)" id="three"><img src="images/star.png"></button>
                        <button onclick="rating(4)"id="four"><img src="images/darkstar.png"></button>
                        <button onclick="rating(5)" id="five"><img src="images/darkstar.png"></button>`;
                clicked = 1;
                selection = 3;
            }
            else if(rating === 4){
                stars.innerHTML = `<button onclick="rating(1)" id="one"><img src="images/star.png"></button>
                        <button onclick="rating(2)" id="two"><img src="images/star.png"></button>
                        <button onclick="rating(3)" id="three"><img src="images/star.png"></button>
                        <button onclick="rating(4)"id="four"><img src="images/star.png"></button>
                        <button onclick="rating(5)" id="five"><img src="images/darkstar.png"></button>`;
                clicked = 1;
                selection = 4;
            }
            else if(rating === 5){
                stars.innerHTML = `<button onclick="rating(1)" id="one"><img src="images/star.png"></button>
                        <button onclick="rating(2)" id="two"><img src="images/star.png"></button>
                        <button onclick="rating(3)" id="three"><img src="images/star.png"></button>
                        <button onclick="rating(4)"id="four"><img src="images/star.png"></button>
                        <button onclick="rating(5)" id="five"><img src="images/star.png"></button>`;
                clicked = 1;
                selection = 5;
            }
        }
        
    </script>
</body>
</html>