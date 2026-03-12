[1mdiff --git a/.github/workflows/cleanup-repo.yaml b/.github/workflows/cleanup-repo.yaml[m
[1mindex 5ddd154..1a44be6 100644[m
[1m--- a/.github/workflows/cleanup-repo.yaml[m
[1m+++ b/.github/workflows/cleanup-repo.yaml[m
[36m@@ -14,7 +14,7 @@[m [mjobs:[m
     steps:[m
 [m
       # Mark issues and PRs with no activity as stale after a while, and close them after a while longer[m
[31m-      - uses: actions/stale@v9[m
[32m+[m[32m      - uses: actions/stale@v10[m
         with:[m
           stale-issue-message: 'Marking issue as stale'[m
           stale-pr-message: 'Marking PR as stale'[m
[1mdiff --git a/.github/workflows/tests.yaml b/.github/workflows/tests.yaml[m
[1mindex 8d3a18a..b0f2aa9 100644[m
[1m--- a/.github/workflows/tests.yaml[m
[1m+++ b/.github/workflows/tests.yaml[m
[36m@@ -18,14 +18,14 @@[m [mjobs:[m
 [m
     steps:[m
       - name: Checkout[m
[31m-        uses: actions/checkout@v4[m
[32m+[m[32m        uses: actions/checkout@v6[m
 [m
       - name: Get Composer Cache Directory[m
         id: composer-cache[m
         run: |[m
           echo "dir=$(make composer-cache-dir)" >> $GITHUB_OUTPUT[m
 [m
[31m-      - uses: actions/cache@v4[m
[32m+[m[32m      - uses: actions/cache@v5[m
         with:[m
           path: ${{ steps.composer-cache.outputs.dir }}[m
           key: ${{ runner.os }}-composer-${{ hashFiles('**/composer.lock') }}[m
