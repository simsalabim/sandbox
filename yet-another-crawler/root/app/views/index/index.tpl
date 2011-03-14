<div class="choice">
  <form id="search" class="search-form" method="post" action="/index/index">

    <div class="filters">
      <div class="group">
        <div class="selection">
          <label for="room_quantity_from">Кол-во комнат, от</label>
          <input type="text" id="room_quantity_from" value="{$params.room_quantity_from}" class="input text" name="room_quantity_from" size="2" maxlength="2"/>
        </div>

        <div class="selection">
          <label for="room_quantity_to">Кол-во комнат, до</label>
          <input type="text" id="room_quantity_to" value="{$params.room_quantity_to}" class="input text" name="room_quantity_to" size="2" maxlength="2"/>
        </div>
      </div>

      <div class="group">
        <div class="selection">
          <label for="price_from">Цена, от</label>
          <input type="text" id="price_from" value="{$params.price_from}" class="input text" name="price_from" size="7" maxlength="7"/>
        </div>

        <div class="selection">
          <label for="price_to">Цена, до</label>
          <input type="text" id="price_to" value="{$params.price_to}" class="input text" name="price_to" size="7" maxlength="7"/>
        </div>
      </div>

      <div class="group">
        <select name="metro[]" multiple size="10" class="input select">
          {foreach from=$metro item=station key=key}
            <option value="{$key}" {if $params.metro && in_array($key, $params.metro)}selected="selected"{/if}>{$station}</option>
          {/foreach}
        </select>
      </div>
    </div>

    <div class="submit" align="center">
      <input type="submit" id="submit" value="Найти" class="submit-button" />
    </div>

  </form>
</div>

<div id="indicator">
  <div class="spin"></div>
</div>
<div id="updater">
  {if $advertisements}
    {include file="index/_search.tpl" advertisements=$advertisements}
  {/if}
</div>