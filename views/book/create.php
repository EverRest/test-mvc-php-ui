<div class="container">
    <div class="row">
        <?php $data = View::$data; ?>
        <form enctype="multipart/form-data" action="<?= URL . 'store' ;?>" method="POST" id="create-form" class="col-md-12">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Enter title" required>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <select class="form-control" name="author" id="author" required>
                    <?php if(!empty($data['authors'])): ?>
                        <?php foreach ($data['authors'] as $author): ?>
                            <option value="<?= $author['id'] ;?>"><?= $author['name'] ;?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="genre">Genre</label>
                <select class="form-control" name="genre" id="genre" required>
                    <?php if(!empty($data['genres'])): ?>
                        <?php foreach ($data['genres'] as $genre): ?>
                            <option value="<?= $genre['id'] ;?>"><?= $genre['name'] ;?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="lang">Language</label>
                <input type="text" name="lang" class="form-control" id="lang" placeholder="Enter language" required>
            </div>
            <div class="form-group">
                <label for="date">Year</label>
                <input type="text" name="date" class="form-control" id="date" placeholder="****" required>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" class="form-control-file" id="photo" required>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN Code</label>
                <input type="text" name="isbn" class="form-control" id="isbn" required>
            </div>
            <button type="submit" class="btn btn-primary">Save!</button>
        </form>
    </div>
</div>