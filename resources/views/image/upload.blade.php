<div>
    <form  method="POST" action="/api/avatar" enctype="multipart/form-data">
        @csrf
        <input type="file" id="image" name="image">
        <button type="submit"> Uploadssss</button>
    </form>
</div>
