document.write('<script type="text/javascript" src="utility_functions.js" ></script>');

document.addEventListener("DOMContentLoaded",()=>
{
    let matrix = document.querySelector('#grid');
    let miniMatrix= document.querySelector('#small-grid')
    const scoreDisplay=document.querySelector('#score');
    const startButton=document.querySelector('#start_button');
    let timerId;


    //grid and mini-grid dimensions
    const gridWidth=10;
    const gridHeight = 20;
    const miniGridWidth=4;
    const miniGridHeight=4;


    //Initialised at -1 so no tetromino is rendered in small grid before start
    let nextTetroIndex=-1;
    let nextColourIndex = 0;
    let score=0;

    const colours=['orange','red','green','blue']
    const square =1;
    const noNextTetro=-1;
    const tetroNumber = 5;

    // Generate random tetromino and colour
    let currentTetroIndex =Math.floor(Math.random()*(tetroNumber));
    let currentColourIndex = Math.floor(Math.random()*(colours.length));

    //Starting position
    let currentPosition=4;
    //Starting rotation
    let currentRotation =0;
    //initial tetromino with given rotation
    let currentTetro=tetro(gridWidth)[currentTetroIndex][currentRotation];




    console.log("Testing");
    //Create 200 cells for grid
    for(x=0; x<(gridHeight+1)*gridWidth;x++) {
        //Get grid

        let cell=document.createElement("div");
        if(x<gridHeight*gridWidth) {
            cell.className = "cells";
            matrix.appendChild(cell);
        }
        else{
            cell.className="occupied";
            matrix.appendChild(cell);
        }
    }

    for(x=0;x<miniGridWidth*miniGridHeight;x++)
    {
        let cell=document.createElement("div");
        miniMatrix.appendChild(cell);
    }

    let gridSquares=Array.from(document.querySelector('#grid').children);

    console.log(gridSquares);


    //Choose random Tetromino from "Tetrominoes" index

    console.log("RandomStart:"+currentTetroIndex);




    //render tetromino
    function render()
    {
        currentTetro.forEach(block=>{
            //classList.add is used to dd one or more classes to css element
            // Here particular blocks in the grid are specified to be restyled within CSS file under class 'tetromino'
            gridSquares[currentPosition+block].classList.add('tetromino');
            gridSquares[currentPosition+block].style.backgroundColor=colours[currentColourIndex];
        })
    }


    function unrender()
    {
        currentTetro.forEach(block => {
            gridSquares[currentPosition +block].classList.remove('tetromino')
            gridSquares[currentPosition+block].style.backgroundColor='';
        })
    }

    function gameEnd()

    {
        let topRow=[];
        for(i=0;i<gridWidth;i++){
            topRow.push(i);
        }
        if(takenSome(topRow)){
            clearInterval(timerId);
            submitScore(score);
           window.alert("Game Over");
           window.location.reload();
           //Clear board and score
        }
    }

    function freezeTetro(cells){

        cells.forEach(block => gridSquares[currentPosition + block].classList.add('occupied'));

    }

    function freeze()
    {
        //Checks next square below in grid for each "block" in teremino to see if it has 'occupied' class name
        if(takenBelow(currentTetro)) {
            //If so, it specifies said blocks of tetromino/grid are added to 'occupied' class.
           freezeTetro(currentTetro);
            gameEnd();
            currentTetroIndex=nextTetroIndex;
            currentColourIndex=nextColourIndex;
            console.log("Random: "+ currentTetroIndex);
            nextTetroIndex = Math.floor(Math.random() * tetroNumber);
            nextColourIndex=Math.floor(Math.random()*colours.length)
            console.log("NextRandom:"+nextTetroIndex);
            //start new tetromino falling
            currentTetro = tetro(gridWidth)[currentTetroIndex][currentRotation];
            currentPosition = 4;
            render();
            renderNextTetro(); // in Mini-Grid
            displayScore();
        }

    }

    // Checks if cells in grid are occupied by tetromino
    function takenTetro(tetroCells)
    {
       return tetroCells.some(block=>gridSquares[currentPosition+block].classList.contains('occupied'));

    }

    // Checks if all cells are occupied
    function takenAll(cells){

        return cells.every(block=>gridSquares[block].classList.contains('occupied'));

    }

    //Checks if any of the cells are occupied
    function takenSome(cells){

    return cells.some(block=>gridSquares[block].classList.contains('occupied'))
    }

    function takenBelow(cells){

        return cells.some(block=>gridSquares[currentPosition +block+gridWidth].classList.contains('occupied'))

    }

    function removeAnyCells(cells){

        cells.forEach(block=>{
            gridSquares[block].classList.remove('occupied');
            gridSquares[block].classList.remove('tetromino');
            gridSquares[block].style.backgroundColor='';

        })
    }


    function moveDown(){

        unrender()
        //Check that there is no conflict before tetromino is rendern
        // withhout check, tetromino is moved down through another tetromino or through grid,then check would happen too late!
        if(!takenTetro(currentTetro)) {
            currentPosition += gridWidth;
        }
        render();
        freeze();
    }

    //move left, prevent tetremino moving off grid by establishing left boundary

    function moveLeft(){
        unrender();

        if(! isAtLeftEdge(currentTetro)){currentPosition-=square;}
        //checks grid square not already taken, if so, then tetremino moved to the right by one square to prevent overlap
        if(takenTetro(currentTetro)){
            currentPosition+=square;
        }
        render();
    }


    function moveRight() {
        unrender();

        if (!isAtRightEdge(currentTetro)) {
            currentPosition += square;
        }
        if (takenTetro(currentTetro)) {
            currentPosition -= square;
        }
        render();
    }

    // Rotates tetromino
    function rotate(){

        let nextRotation=(currentRotation+1)%currentTetro.length;
        let next =tetro(gridWidth)[currentTetroIndex][nextRotation];

        unrender();

        console.log(currentPosition);
        console.log("Current:"+currentTetro);
        console.log("Next: "+next);
        //Stops tetromino passing through another during rotation
        //Stops tetromino passing through left boundary while rotating
        //Stops tetromino passing through right boundary while rotating
       if(!takenTetro(next)&&!isSplit(next)) {
           currentRotation = nextRotation;
           console.log("No block on boundary!");
       }
        currentTetro=tetro(gridWidth)[currentTetroIndex][currentRotation];
        render();

    }

    //Returns true if there are tetromino blocks on left AND right side of grid i.e. split tetromino
    function isSplit(tetromino){
        return (isAtLeftEdge(tetromino)&&isAtRightEdge(tetromino));
    }

    //Checks right-hand boundary
    function isAtRightEdge(tetromino)
    {

        return tetromino.some(block => (currentPosition + block) % 10 === 9);

    }

    //Checks left-hand boundary
    function isAtLeftEdge(tetromino) {

        return tetromino.some(block=>(currentPosition+block)%10===0);

    }


    //Binds keys/events to functions
    function keyControls(e)
    {
        switch(e.keyCode) {

            case(37): {moveLeft(); break;}  //move left
            case(39): { moveRight(); break;} //move right
            case(40):{moveDown();break;} //move down
            case(82): { rotate();break;} //rotate

        }
    }

    const smallGridSquares=document.querySelectorAll("#small-grid div");
    console.log(smallGridSquares);
    let displayIndex=0;


    //Render next tetromino in small grid
    function renderNextTetro()
    {
        smallGridSquares.forEach(square=>{
            square.classList.remove('tetromino')
            square.style.backgroundColor='';
        })

        tetro(miniGridWidth)[nextTetroIndex][0].forEach(block=>{
            smallGridSquares[displayIndex+block].classList.add('tetromino');
            smallGridSquares[displayIndex+block].style.backgroundColor=colours[nextColourIndex];
        })

}

//Removes complete rows and updates score display
function displayScore(){
for(let i=0;i<gridHeight;i++)
{
    let row = [];
    for(let j=0;j<gridWidth;j++){
        row.push(i*gridWidth+j)
    }
    console.log(row);
    if(takenAll(row)){
        score+=10;
        scoreDisplay.innerHTML=score;
        removeAnyCells(row)
        //Full row is removed, now all remaining blocks need to move down one unit
        const squaresRemoved=gridSquares.splice(i*gridWidth,gridWidth);

        console.log(squaresRemoved);
        //row reinserted by combining squares with squares removed array
        gridSquares=squaresRemoved.concat(gridSquares);
        console.log(gridSquares);
        console.log(matrix.childNodes);
       gridSquares.forEach(cell=>matrix.appendChild(cell));
        console.log(matrix.childNodes);

    }

}

}

 startButton.addEventListener('click',()=>{
        if(timerId){
            clearInterval(timerId);//is not null
                timerId=null; //Pauses game
            document.removeEventListener('keyup',keyControls);
        }
        else{
            //Starts/resumes game
            render();

            //make the teromino move down grid every second/1000ms
            timerId=setInterval(moveDown,1000);
            document.addEventListener('keyup', keyControls);
            if(nextTetroIndex===noNextTetro) {
                nextTetroIndex = Math.floor(Math.random() * tetro.length);
                console.log("NextRandom: "+nextTetroIndex)
                renderNextTetro();
            }
        }})

})



