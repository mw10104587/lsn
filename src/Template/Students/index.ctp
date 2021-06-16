<h1>受講生管理</h1>
<h3>一覽</h3>

<?= $this->Html->css('https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css'); ?>
<table id='table'>
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
                        'class' => 'information',
                        'onclick' => 'getInformation(this)'
                    ])
                ]
            ],
            [ 'class' => 'odd', 'id' => $result->id ],
            [ 'id' => $result->id ]); ?>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->Html->link(
    'Modal',
    '#modal',
    [
        'id' => 'switch',
        'rel' => 'modal:open',
        'style' => 'display: none'
    ])
?>

<div id='modal'>
    <?= $this->Html->div('', '', ['id' => 'student_name']) ?>
    <?= $this->Html->div('', '', ['id' => 'parents_name']) ?>
    <?= $this->Html->div('', '', ['id' => 'phone']) ?>
    <a href='#' rel='modal:close'>Close</a>
</div>

<?= $this->Html->script('https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'); ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js'); ?>
<?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css'); ?>
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
                $('#switch').trigger('click');
                $('#student_name').text('Student Name: ' + data.student_name);
                $('#parents_name').text('Parents Name: ' + data.parent.parents_name);
                $('#phone').text('Parents Phone: ' + data.parent.phone);
            },
        });
    }
</script>