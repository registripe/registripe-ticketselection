<h3>Choose tickets:</h3>
<div class="ticketselectionlist">
<% loop Tickets %>
	<div class="row">
		<div class="ticket">
			<div class="ticket_header">
				<div class="col-xs-10">
					<span class="ticket_row">
						<span class="ticket_row_title">$Title</span>
						<div class="ticket_row_secondary">
							<% if $SubTitle %><span class="ticket_row_subtitle"> $SubTitle</span><% end_if %>
							<% if $Top.ShowPrices && ShowFreeLabel %> <span class="ticket_row_price">$Price.Nicer</span><% end_if %>
						</div>
					</span>
				</div>
				<div class="col-xs-2 text-right">
					<form method="POST" action="$Top.Link(selectTicket)/$ID">
						<% if $Top.SelectedCount($ID) %>
							<div class="input-group input-group-sm">
								<span class="input-group-btn">
									<button class="btn btn-default btn-number" type="submit" name="action_subtract">
										<span class="glyphicon glyphicon-minus"></span>
									</button>
								</span>
								<span class="input-group-addon">
									$Top.SelectedCount($ID)
								</span>
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit" name="action_add">
										<span class="glyphicon glyphicon-plus"></span>
									</button>
								</span>
							</div>
						<% else %>
							<button class="btn btn-default" type="submit" name="action_add">Add</button>
						<% end_if %>
					</form>
				</div>
			</div>
			<% if $Description %>
				<div class="ticket_details">
					<div class="col-xs-12">
						<div class="well">
							$Description
						</div>
					</div>
				</div>
			<% end_if %>
		</div>
	</div>
<% end_loop %>
</div>

<% if CurrentRegistration.Cost %>
	<div class="calculation_subtotal">
		<div class="text-right">
			<strong>Total: $CurrentRegistration.Cost.Nice</strong>
		</div>
	</div>
<% end_if %>

<% if FirstSelectionLink %>
	<a class="btn btn-primary" href="$FirstSelectionLink">Next</a>
<% end_if %>