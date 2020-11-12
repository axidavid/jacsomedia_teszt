<?php
    require_once("header.html");
    session_start();
    if(!isset($_SESSION["userid"]) || !$_SESSION["userid"] == 1)
    {
        header("Location: index.php");
    }
?>

<div class="text-center container row">
<div id='list' class="col-6">
</div>
<div id='list2' class="col-6">
</div>
</div>
<div class="text-center mt-5">
    <button type="submit" class="save-button mt-3" onclick="savelist();">SAVE</button>
    <p id="save-text" class="form-error-text mt-4"></p>
</div>

<script>
    $('a[href$="mpaf.php"]').addClass("header-text-active");

    var dragging, draggedOver, dragged, dropped;

    var items = ['DOG', 'CAT', 'FROG', 'COW', 'SHEEP', 'LION'];
    var items2 = ['POUND', 'FISH', 'FOOT', 'MILK', 'SUPER', 'HEART'];

    $.ajax({
        url: "ajax_download.php",
    }).done(function(data) {
        arrays = data.split("|");
        back_items = arrays[0].split(",");
        back_items2 = arrays[1].split(",");
        found1 = 0;
        found2 = 0;
        items.forEach(function(item, index){
            if(found1 > back_items.indexOf(item))
                found1 = back_items.indexOf(item);
        });
        items2.forEach(function(item, index){
            if(found2 > back_items2.indexOf(item))
                found2 = back_items2.indexOf(item);
        });

        if(found1 != -1)
        {
            items = back_items;
            list = document.getElementById('list');
            renderItems(items, "rgb(79,45,127)", list);
        }
        if(found2 != -1)
        {
            items2 = back_items2;
            list2 = document.getElementById('list2');
            renderItems(items2, "deeppink", list2);
        }
    });

    const renderItems = (data, color, list_here) =>{
    list_here.innerText = '';
    data.forEach(item=>{
        var node = document.createElement("div");
        var p = document.createElement("p");    
        node.draggable = true
        $(node).addClass('list-item');
        $(p).addClass('list-item-paragraph');
        node.style.backgroundColor = color;
        node.addEventListener('drag', setDragging) ;
        node.addEventListener('dragover', setDraggedOver);
        node.addEventListener('drop', compare);
        p.innerText = item;
        node.appendChild(p);
        list_here.appendChild(node);
    });
    }

    const compare = (e) =>{
        if($(dragged).css('backgroundColor') == $(dropped).parent().css('backgroundColor'))
        {
            cheking_items = $(dragged).css('backgroundColor') == 'rgb(255, 20, 147)' ? items2 : items;
            console.log($(dragged).css('backgroundColor'));
            var index1 = cheking_items.indexOf(dragging);
            var index2 = cheking_items.indexOf(draggedOver);
            cheking_items.splice(index1, 1);
            cheking_items.splice(index2, 0, dragging);
            renderItems(cheking_items, $(dragged).css('backgroundColor'), document.getElementById($(dragged).parent().attr('id')));
        }
    };

    const setDraggedOver = (e) => {
        e.preventDefault();
        draggedOver = Number.isNaN(parseInt(e.target.innerText)) ? e.target.innerText : parseInt(e.target.innerText);
        dropped = e.target;
    }

    const setDragging = (e) =>{
        dragging = Number.isNaN(parseInt(e.target.innerText)) ? e.target.innerText : parseInt(e.target.innerText);
        dragged = e.target;
    }

    list = document.getElementById('list');
    list2 = document.getElementById('list2');
    renderItems(items, "rgb(79,45,127)", list);
    renderItems(items2, "deeppink", list2);


    function savelist()
    {
        $.ajax({
            url: "ajax_upload.php",
            data: { list1 : items, list2 : items2 }
        }).done(function(data) {
            $("#save-text").html(data);
            setTimeout(function(){  $("#save-text").html(''); }, 3000);
        });
    }

</script>
<?php
  require_once("footer.html")
?>