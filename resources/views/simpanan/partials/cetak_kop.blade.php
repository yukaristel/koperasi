<!DOCTYPE html>
<html lang="en">

<head>

    <style type="text/css">
    <!--
    .style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px;  }
    .style9 {font-family: 'system-ui'; font-size: 12px; }
    .style10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
    .top	{border-top: 1px solid #000000; }
    .bottom	{border-bottom: 1px solid #000000; }
    .left	{border-left: 1px solid #000000; }
    .right	{border-right: 1px solid #000000; }
    .all	{border: 1px solid #000000; }
    .style26 {font-family: Verdana, Arial, Helvetica, sans-serif}
    .style27 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
    .align-justify {text-align:justify; }
    .align-center {text-align:center; }
    .align-right {text-align:right; }
    -->
    </style>

</head>
<body class="g-sidenav-show  bg-gray-200" onload="window.print()">
<table width="100%" border="0"  align="center" cellpadding="3" cellspacing="0" style="margin-top:10px; "> 
      <tr>
       
        <td colspan="2" class="style9">&nbsp;</td>
        <td width="25%" class="style9 align-right">&nbsp;</td>
        <td width="15%" class="style9">&nbsp;</td>

      </tr>
      <tr>
        <td width="20%" class="style9">&nbsp; </td>
        <td class="style9"> &nbsp;</td> 
       
        <td width="10%" class="style9 align-right"><strong> CIF - {{ $simpanan->jenis_simpanan }}.{{ $simpanan->id }}</strong></td>
      </tr>
      <tr>
        <td colspan="2" class="style9">&nbsp;<br>&nbsp;<br>&nbsp;<br></td>
      </tr>
      <tr>
        <td width="20%" class="style9">&nbsp; </td>
        <td colspan="2" class="style9"> {{ $simpanan->anggota->namadepan }} </td> 
       
      </tr>
      <tr>
        <td class="style9">&nbsp; </td>
         <td class="style9"> {{ $simpanan->nomor_rekening }}</td>
      </tr>
      <tr>
        <td class="style9">&nbsp; </td>
        <td colspan="2" class="style9"> {{ $simpanan->anggota->alamat }} {{ $simpanan->nama_desa }}</td>
      </tr>
      
      <tr>
        <td class="style9"> </td>
         <td colspan="2" class="style9"> </td>
      </tr>
      
</table>
</body>

</html>
