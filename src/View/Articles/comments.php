<?php
for ($i = 0; $i < count($scope); $i++) {
    $comment = $scope[$i]['commentaire'];
    $date_comment = $scope[$i]['date_comment'];
    echo "<p>$comment <br>";
    echo "$date_comment </p>";
    echo "<hr/>";
}
?>
</div>
</div>
</div>