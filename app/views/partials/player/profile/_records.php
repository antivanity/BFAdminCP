<div class="table-responsive">
    <table class="table table-striped table-condensed">
        <thead>
            <th>Date</th>
            <th class="hidden-sm">CMD Issued</th>
            <th>CMD Taken</th>
            <th>Target</th>
            <th class="hidden-sm">Source</th>
            <th class="hidden-sm">Server</th>
            <th width="25%">Message</th>
        </thead>
        <tbody>
            <tr ng-repeat="(key, record) in records.data">
                <td ng-bind="moment(record.stamp).format('MMM D, YYYY h:mm:ss a')"></td>
                <td class="hidden-sm" ng-bind="record.type.command_name"></td>
                <td ng-bind="record.action.command_name"></td>
                <td>
                    <ng-switch on="record.target !== null && record.target.PlayerID != playerId">
                        <a ng-switch-when="true" ng-href="{{ record.target.profile_url }}" target="_blank" ng-bind="record.target.SoldierName"></a>
                        <span ng-switch-default ng-bind="record.target_name"></span>
                    </ng-switch>
                </td>
                <td class="hidden-sm">
                    <ng-switch on="record.source !== null && record.source.PlayerID != playerId">
                        <a ng-switch-when="true" ng-href="{{ record.source.profile_url }}" target="_blank" ng-bind="record.source.SoldierName"></a>
                        <span ng-switch-default ng-bind="record.source_name"></span>
                    </ng-switch>
                </td>
                <td class="hidden-sm">
                    <span ng-bind="record.server.server_name_short || (record.server.ServerName | limitTo: 30)" tooltip="{{ record.server.ServerName }}"></span>
                </td>
                <td>
                    <span ng-if="record.action.command_id == 7 || record.action.command_id == 72" class="badge bg-purple" ng-bind="momentDuration(record.command_numeric, 'minutes')"></span>
                    <span ng-bind="record.record_message"></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>