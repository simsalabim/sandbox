<table class="results" cellpadding="0" cellspacing="0">
  <thead>
    <tr class="table-header">
      <th>Издание</th>
      <th>Ком.</th>
      <th>Адр.</th>
      <th>Метро</th>
      <th>Этаж</th>
      <th>Тип</th>
      <th>Площадь (общая, жилая, кухня)</th>
      <th>Тел.</th>
      <th>С/У</th>
      <th>Субъект</th>
      <th>Контакт</th>
      <th>Доп.инфо</th>
    </tr>
  </thead>
  <tbody>
    {foreach from=$advertisements item=ad key=i}
      <tr class="{cycle values="even,odd"}">
        <td align="center">{$ad.edition}</td>
        <td align="center">{$ad.rooms}</td>
        <td align="center">{$ad.address}</td>
        <td align="center">{$ad.metro}</td>
        <td align="center">{$ad.floor}</td>
        <td align="center">{$ad.type}</td>
        <td align="center">{$ad.square.common}, {$ad.square.habitant}, {$ad.square.kitchen}</td>
        <td align="center">{$ad.phone}</td>
        <td align="center">{$ad.bathroom}</td>
        <td align="center">{$ad.subject}</td>
        <td align="center">{$ad.contact}</td>
        <td align="center">{$ad.additional}</td>
      </tr>
    {/foreach}
  </tbody>
</table>