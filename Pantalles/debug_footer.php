<?php
if (isset($GLOBALS['DEBUG_SQL']) && $GLOBALS['DEBUG_SQL'] === true)
{
    ?>
    <div style="display: block; width: 100%; height: 200px; overflow-y: scroll; margin: 0px; padding: 0px; bottom: 0px; right: 0px; position: fixed; background-color: rgba(127, 188, 204, 0.9); z-index: 100;">
        <p><br>Temps inici: <?php echo $tempsinici ?></p>
        <?php
        $debug_total_queries = 0;
        foreach ($GLOBALS['DEBUG_SQL_QUERIES'] as $debug_query_md5 => $debug_query_array)
        {
            ?>
            <ul style="font-size: 12px; font-family: monospace; margin: 5px; padding: 0px;margin-bottom:20px;">
                <?php
                foreach ($debug_query_array as $key => $value)
                {
                    echo '<li style="font-size: 12px; font-family: monospace; margin: 5px; padding: 0px;">' . $key . ': ' . $value . '</li>';
                    if ($key === 'count')
                    {
                        $debug_total_queries += $value;
                    }
                }
                ?>
            </ul>
            <?php
        }
        ?>        
        <p><br>Total queries: <?php echo $debug_total_queries; ?></p>
        <p><br>Temps Fi: <?php echo date("h:i:s") ?></p>
    </div>
    <?php
}
?>