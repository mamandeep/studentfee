<style>
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}

table {
    width: 100%;
}

th {
    height: 50px;
    text-align: center;
}
td {
    height: 50px;
    text-align: center;
    vertical-align: bottom;
}
</style>
<a href="javascript: window.print();" > PRINT </a>
<h1>Allocated Seats Details</h1>
<div>
<table>
    <tr>
        <th>Programme Name</th>
        <th>Seat Category</th>
        <th>Seat ID</th>
    </tr>
     <?php  $count = 1;
        foreach ($allocatedSeats as $seat): ?>
    <tr>
        <td><?php //debug($seat); ?>
            <?= $seat['Programmes__name'] ?>
        </td>
        <td>
            <?= $seat['Categories__type'] ?>
        </td>
        <td>
            <?= $seat['Seatallocations__seat_id'] ?>
        </td>
        
    <tr>
    <?php endforeach; ?>
<table>
</div>