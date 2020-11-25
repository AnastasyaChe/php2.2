<style>
    table{
        border-collapse: collapse;
    }
    td   {
        padding: 2px 4px;
        border: 1px solid black;
    }
</style>

<table>
    <?php foreach ($basket as $item): ?>
    <tr>
        <td>
            <?= $item['product']['name'] ?>
        </td>
        <td>
            <?= $item['qty'] ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>