<div id="outgoing">
    <filter-component @search="search" @datechange="onChangeDate" ></filter-component>
    <outgoing-list :outgoings="filteredOutgoings" :isLoading="isLoading" />
</div>