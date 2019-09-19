hello there
<script>
    function setRank(elem){
        var root=elem.parentNode;
        var i;
        for(i=root.firstChild; i!=elem.nextSibling; i=i.nextSibling)
            if (i.id=="star")
                i.style.color='orange';
        for(i; i; i=i.nextSibling)
            if (i.id=="star")
                i.style.color='grey';
    }
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    .unchecked {
        color: grey;
    }
</style>
<div>
    <div class="fa fa-star unchecked" id="star" onclick="setRank(this);"></div>
    <div class="fa fa-star unchecked" id="star" onclick="setRank(this);"></div>
    <div class="fa fa-star unchecked" id="star" onclick="setRank(this);"></div>
    <div class="fa fa-star unchecked" id="star" onclick="setRank(this);"></div>
    <div class="fa fa-star unchecked" id="star" onclick="setRank(this);"></div>
</div>