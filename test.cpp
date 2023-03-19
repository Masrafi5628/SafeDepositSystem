#include <bits/stdc++.h>
using namespace std;
#define file                          \
    freopen("input.txt", "r", stdin); \
    freopen("output.txt", "w", stdout);
#define fo(i, strt, end) \
    for (i = strt; strt < end ? i < end : i > end; strt < end ? i += 1 : i -= 1)
#define deb(var) cout << #var << " = " << var << endl;
#define deba(i, arr, n) \
    fo(i, 0, n) { cout << arr[i] << " "; }
#define all(arr) arr.begin(), arr.end()
#define rall(arr) arr.rbegin(), arr.rend()
#define autoDeb(arr) \
    for (auto var : arr) cout << var << " ";
#define sa(arr, n) \
    for (int var = 0; var < n; var++) cin >> arr[var];
#define yes cout << "YES\n"
#define no cout << "NO\n"
typedef long long ll;
#define ll long long
typedef vector<int> vi;
typedef pair<int, int> pii;
typedef map<int, int> mii;
/*************************************/

int main() {
    ios_base::sync_with_stdio(0), cin.tie(0), cout.tie(0);
    // file;
    int a = 3;cout<<sizeof(int)<<endl;
    string str="11111111111111111111111111111111111111111111111111111111111111";cout<<str.size()<<endl;
    bitset<100> b1 = a, b2;
    a = ~a;
    b2 = a;
    cout << b1 << endl << b2 << endl;
    return 0;
}