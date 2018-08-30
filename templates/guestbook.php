<table border="1px">
    <tr><td>Name</td><td>Email</td><td>Message</td><td>Created At</td></tr>
    <? foreach($messages as $message): ?>
        <tr><td><?= $message['name'] ?></td><td><?= $message['email'] ?></td><td><?= $message['message'] ?></td><td><?= $message['created_at'] ?></td></tr>
    <? endforeach; ?>
</table>