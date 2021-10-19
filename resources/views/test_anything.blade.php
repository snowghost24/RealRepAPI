<div>
    <form  method="POST" action="/api/comments" enctype="multipart/form-data">
        @csrf
        <input type="text" id="commentable_type" name="commentable_type" value="NewsArticle">
        <input type="text" id="commentable_id" name="commentable_id" value="1">
        <input  type="text" id="message" name="message" value="Thisis my meessage 00">
        <button type="submit"> Uploadssss</button>
    </form>
</div>
