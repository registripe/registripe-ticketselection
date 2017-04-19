<tr>
	<td><label for="attendee_$ID">$Attendee.Name</label></td>
	<td>$Ticket.Title</td>
	<td>$Cost.Nicer</td>
	<td>
		<a href="$BaseLink/selection/$ID" class="btn btn-primary btn-sm">edit</a>
		<a href="$BaseLink/selection/$ID/delete" class="btn btn-danger btn-sm">remove</a>
	</td>
</tr>
<% with Attendee %>
	<% include AttendeesReviewTable_AddOnRows %>
<% end_with %>