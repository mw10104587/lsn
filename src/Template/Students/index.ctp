<h1>受講生管理</h1>
<h3>一覽</h3>

<?= $this->Html->css('https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css') ?>

<!-- Modal -->
<div class="modal fade" id="informationModal" tabindex="-1" aria-labelledby="informationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="informationModalLabel">情報</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <p class="fw-bold">Students Name: </p>
                    <p class="fw-normal" id="student-name"></p>
                </div>
                <div>
                    <p class="fw-bold">Parents Name: </p>
                    <p class="fw-normal" id="parents-name"></p>
                </div>
                <div>
                    <p class="fw-bold">Parents Phone: </p>
                    <p class="fw-normal" id="phone"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<table id='table' class="table table-hover">
    <thead>
        <?= $this->Html->tableHeaders([
            'No',
            '名前',
            'フリガナ',
            '学年',
            'エリア',
            'クラス',
            '教室',
            '保護者',
            '電話',
            '操作']);
        ?>
    </thead>
    <tbody>
        <?php foreach($results as $result): ?>
            <?= $this->Html->tableCells([
                [
                    $result->id,
                    $result->student_name,
                    $result->student_furigana,
                    $result->school_year,
                    $result->classroom,
                    $result->class,
                    $result->subject,
                    $result->parent->parents_name, 
                    $result->parent->phone,
                    $this->Form->button('情報', [
                        'class' => 'btn btn-primary',
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#informationModal',
                        'onclick' => 'getInformation(this)' 
                    ])
                ]
            ],
            [ 'class' => 'odd', 'id' => $result->id ],
            [ 'id' => $result->id ]); ?>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->Html->script('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') ?>
<?= $this->Html->script('https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js') ?>
<script>
    $(document).ready(() => {
        $('#table').DataTable();
    });

    function getInformation(element) {
        let id = element.closest('tr').id;
        let csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
        $.ajax({
            method: 'POST',
            url: 'students/information/' + id,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-Token': csrfToken
            },
            success: (res) => {
                let data = JSON.parse(res);
                $('#student-name').text(data.student_name);
                $('#parents-name').text(data.parent.parents_name);
                $('#phone').text(data.parent.phone);
            },
        });
    }
</script>