<h1>受講生管理</h1>
<h3>一覽</h3>

<?= $this->Html->css('https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css'); ?>
<table id="table" class="display">
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
                    $this->Html->link('操作')
                ]
            ]); ?>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->Html->script('https://code.jquery.com/jquery-3.3.1.js'); ?>
<?= $this->Html->script('https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'); ?>

<script>
    $(document).ready(() => {
        $('#table').DataTable();
    });
</script>