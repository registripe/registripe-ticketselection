<table class="table">
	<thead>
		<tr>
			<td>Name</td>
			<td>Ticket</td>
			<td>Cost</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		<% loop	TicketSelections %>
			$RenderRow($Up.ControllerLink)
		<% end_loop %>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">Total</th>
			<td>$Total.Nicer</td>
			<td colspan="2"></td>
		</tr>
	</tfoot>
</table>