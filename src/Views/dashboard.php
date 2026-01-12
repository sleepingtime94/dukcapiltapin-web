<div class="container">
    <div class="my-4">
        <div class="row">
            <div class="col-md-6">
                <form id="create-article-form">
                    <input type="hidden" id="article-id" name="id">
                    <div class="form-group mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="created" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="created" name="created">
                    </div>
                    <div class="form-group mb-3">
                        <label for="permalink" class="form-label">Permalink</label>
                        <input type="text" class="form-control" id="permalink" name="permalink" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="file" class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="file" name="file">
                    </div>
                    <div class="form-group mb-3">
                        <label for="file-preview" class="form-label">Image Preview</label>
                        <input type="text" class="form-control" id="image" name="image">
                        <img id="file-preview" src="#" alt="Preview" class="img-fluid" style="max-height: 200px;">
                    </div>

                    <div class="form-group mb-3">
                        <label for="content">Konten</label>
                        <textarea class="form-control" id="content" name="content" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $value): ?>
                                <tr class="article-row" data-id="<?= $value['id'] ?>">
                                    <td><?= $value['created'] ?></td>
                                    <td><?= $value['title'] ?></td>
                                    <td>
                                        <a href="<?= $value['permalink'] ?>" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="bi bi-link-45deg"></i> View
                                        </a>
                                        <button type="button" class="btn btn-sm btn-success">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const fileInput = document.getElementById('file');
    const filePreview = document.getElementById('file-preview');

    // Handle file input change for preview
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                filePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);

        }
    });

    // AJAX file upload function
    function uploadFile(file) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            const formData = new FormData();
            formData.append('file', file);

            xhr.open('POST', '/upload', true);

            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    console.log(`Upload progress: ${percentComplete.toFixed(2)}%`);
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        resolve(response);
                    } catch (err) {
                        reject(err);
                    }
                } else {
                    reject(new Error('Upload failed'));
                }
            };

            xhr.onerror = function() {
                reject(new Error('Network error'));
            };

            xhr.send(formData);
        });
    }

    // Handle file input change for upload
    fileInput.addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (file) {
            try {
                const uploadResponse = await uploadFile(file);
                console.log('File uploaded:', uploadResponse);
                // Optionally set preview if server returns URL
                if (uploadResponse.fileUrl) {
                    filePreview.src = uploadResponse.fileUrl;
                    document.getElementById('image').value = uploadResponse.fileUrl;
                }
            } catch (err) {
                console.error('Upload error:', err);
                alert('File upload failed');
            }
        }
    });

    function setEditingState(isEditing) {
        const submitButton = document.querySelector('#create-article-form button[type="submit"]');
        submitButton.textContent = isEditing ? 'Update' : 'Submit';
    }

    function fillFormWithArticle(article) {
        document.getElementById('article-id').value = article.id ?? '';
        document.getElementById('title').value = article.title ?? '';
        document.getElementById('created').value = article.created ?? '';
        document.getElementById('permalink').value = article.permalink ?? '';
        document.getElementById('image').value = article.cover ?? '';
        document.getElementById('content').value = article.content ?? '';

        if (article.cover) {
            filePreview.src = article.cover;
        }

        setEditingState(true);
    }

    // Handle form submission for article creation/update
    document.getElementById('create-article-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        delete data.file;

        const endpoint = data.id ? '/update-article' : '/create-article';

        fetch(endpoint, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                alert(data.message);
                location.reload()
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    });

    // Handle delete/edit button click
    document.querySelectorAll('.article-row').forEach(row => {
        row.addEventListener('click', function(e) {
            const deleteButton = e.target.closest('.btn-danger');
            if (deleteButton) {
                const articleId = this.dataset.id;
                if (confirm('Are you sure you want to delete this article?')) {
                    fetch(`/delete-article/${articleId}`, {
                            method: 'DELETE'
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            alert(data.message);
                            location.reload()
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred. Please try again.');
                        });
                }
            }

            const editButton = e.target.closest('.btn-success');
            if (editButton) {
                const articleId = this.dataset.id;
                fetch(`/article/${articleId}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (!response.success) {
                            throw new Error(response.message || 'Failed to load article');
                        }
                        fillFormWithArticle(response.data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to load article. Please try again.');
                    });
            }
        });
    });
</script>