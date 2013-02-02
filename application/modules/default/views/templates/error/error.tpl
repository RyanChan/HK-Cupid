<div class="container">
    <h1>404</h1>
    <div class="hero-unit">
        <p>
            你訪問的頁面並不存在
        </p>
        {if $exception}
            {$exception->getMessage()|escape}
        {/if}
        <a href="javascript:history.back(1);" class="btn">返回</a>
        <a href="/" class="btn btn-info">主頁</a>
    </div>
</div>