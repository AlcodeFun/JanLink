<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Pedagang</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2>Tambah Kategori</h2>
        <hr class="ms-auto me-auto mb-5">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_kategori" class="form-label">nama_kategori</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required />
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">gambar (Image)</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and other scripts as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>