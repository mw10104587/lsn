<h1>入退室管理</h1>
<h3>履歷一覽</h3>

<?= $this->Html->css('https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css'); ?>
<table id="table" class="display">
    <thead>
        <?= $this->Html->tableHeaders([
            '日時',
            '名前',
            '入退室',
            '電話',
            'Missing number',
            '操作']);
        ?>
    </thead>
    <tbody>
        <?php foreach($results as $result): ?>
            <?= $this->Html->tableCells([
                [
                    $result->created,
                    $result->student_name,
                    $result->enter_or_exit,
                    $result->phone,
                    '',
                    $this->Html->link('情報')
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