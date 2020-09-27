<?php
$system_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;
if ($month == 1)
    $m = get_phrase('january');
else if ($month == 2)
    $m = get_phrase('february');
else if ($month == 3)
    $m = get_phrase('march');
else if ($month == 4)
    $m = get_phrase('april');
else if ($month == 5)
    $m = get_phrase('may');
else if ($month == 6)
    $m = get_phrase('june');
else if ($month == 7)
    $m = get_phrase('july');
else if ($month == 8)
    $m = get_phrase('august');
else if ($month == 9)
    $m = get_phrase('september');
else if ($month == 10)
    $m = get_phrase('october');
else if ($month == 11)
    $m = get_phrase('november');
else if ($month == 12)
    $m = get_phrase('december');
?>

<div id="print">
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <style type="text/css">
        td {
            padding: 5px;
        }
    </style>

    <center>
        <br>
        <img src="<?php echo base_url();?>uploads/logo.png" style="max-height : 60px;"><br>
        <h3 style="font-weight: 100;"><?php echo $system_name; ?></h3>
        <?php echo get_phrase('attendance_sheet'); ?><br>
        <?php echo $m . ' ' . $year; ?><br><br>

    </center>

    <table border="1" style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;">
        <thead>
            <tr>
                <td style="text-align: center;">
                    <?php echo get_phrase('employee'); ?> |
                    <?php echo get_phrase('date'); ?>
                </td>
                <?php
                $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                for($i = 1; $i <= $days; $i++) { ?>
                    <td style="text-align: center;"><?php echo $i; ?></td>
                <?php } ?>
            </tr>
        </thead>

        <tbody>
            <?php
            $employee = $this->db->get_where('user',
                array('user_id' => $this->session->userdata('login_user_id')))->result_array();
            foreach($employee as $row) { ?>
                <tr>
                    <td style="text-align: center;">
                        <?php echo $row['name']; ?>
                    </td>
                    <?php
                    for ($i = 1; $i <= $days; $i++) {
                        $date = strtotime($i . '-' . $month . '-' . $year);
                        $query = $this->db->get_where('attendance', array('user_id' => $row['user_id'], 'date' => $date)); ?>
                        <?php
                            if ($query->num_rows() > 0)
                                $status = $query->row()->status;
                            else
                                $status = '';
                         ?>
                        <td style="text-align: center;">
                            <?php if ($status == 1) { ?>
                                <div style="color: #159D1A">P</div>
                            <?php } else if ($status == 2) { ?>
                                <div style="color: #ff3030">A</div>
                            <?php } ?>
                        </td>

                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">

    jQuery(document).ready(function ($)
    {
        var elem = $('#print');
        PrintElem(elem);
        Popup(data);

    });

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>
